<?php

namespace Creem\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use Psr\Http\Message\ResponseInterface;
use Creem\Exceptions\AuthenticationException;
use Creem\Exceptions\ConnectionException;
use Creem\Exceptions\CreemException;
use Creem\Exceptions\NotFoundException;
use Creem\Exceptions\RateLimitException;
use Creem\Exceptions\TimeoutException;
use Creem\Exceptions\ValidationException;

class HttpClient
{
    protected Client $client;
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => $this->getBaseUrl(),
            'timeout' => $config['timeout'] ?? 30,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'x-api-key' => $config['api_key'] ?? '',
            ],
        ]);
    }

    protected function getBaseUrl(): string
    {
        $environment = $this->config['environment'] ?? 'production';
        $urls = $this->config['base_url'] ?? [];

        return $urls[$environment] ?? 'https://api.creem.io';
    }

    public function get(string $path, array $query = []): array
    {
        return $this->request('GET', $path, ['query' => $query]);
    }

    public function post(string $path, array $data = []): array
    {
        $data = array_filter($data, fn($v) => $v !== null);
        return $this->request('POST', $path, ['json' => $data]);
    }

    public function delete(string $path, array $query = []): array
    {
        return $this->request('DELETE', $path, ['query' => $query]);
    }

    protected function request(string $method, string $path, array $options = []): array
    {
        $retryConfig = $this->config['retry'] ?? [];
        $maxRetries = $this->calculateMaxRetries($retryConfig);
        $attempt = 0;

        while (true) {
            try {
                $response = $this->client->request($method, $path, $options);
                return $this->parseResponse($response);
            } catch (ConnectException $e) {
                if ($this->shouldRetryConnection($retryConfig, $attempt, $maxRetries)) {
                    $attempt++;
                    $this->sleep($this->calculateBackoff($retryConfig, $attempt));
                    continue;
                }
                throw new ConnectionException($e->getMessage(), $e);
            } catch (RequestException $e) {
                $response = $e->getResponse();
                $statusCode = $response?->getStatusCode();

                if ($this->shouldRetryStatus($retryConfig, $statusCode, $attempt, $maxRetries)) {
                    $attempt++;
                    $this->sleep($this->calculateBackoff($retryConfig, $attempt));
                    continue;
                }

                throw $this->createException($e, $response);
            } catch (TransferException $e) {
                throw new ConnectionException($e->getMessage(), $e);
            }
        }
    }

    protected function parseResponse(ResponseInterface $response): array
    {
        $body = (string) $response->getBody();
        return json_decode($body, true) ?? [];
    }

    protected function createException(RequestException $e, ?ResponseInterface $response): CreemException
    {
        $statusCode = $response?->getStatusCode();
        $body = $response ? (string) $response->getBody() : null;
        $headers = $response?->getHeaders() ?? [];
        $message = $e->getMessage();

        if ($body) {
            $decoded = json_decode($body, true);
            if (isset($decoded['message'])) {
                $message = is_array($decoded['message'])
                    ? json_encode($decoded['message'])
                    : $decoded['message'];
            }
        }

        return match ($statusCode) {
            400 => new ValidationException($message, $body, $headers, $e),
            401 => new AuthenticationException($message, $body, $headers, $e),
            404 => new NotFoundException($message, $body, $headers, $e),
            429 => new RateLimitException($message, $body, $headers, $e),
            default => new CreemException($message, $statusCode, $body, $headers, $response, $e),
        };
    }

    protected function shouldRetryConnection(array $config, int $attempt, int $maxRetries): bool
    {
        if (($config['strategy'] ?? 'none') === 'none') {
            return false;
        }
        return ($config['retry_connection_errors'] ?? true) && $attempt < $maxRetries;
    }

    protected function shouldRetryStatus(array $config, ?int $statusCode, int $attempt, int $maxRetries): bool
    {
        if (($config['strategy'] ?? 'none') === 'none') {
            return false;
        }
        if ($attempt >= $maxRetries) {
            return false;
        }
        $retryCodes = $config['retry_codes'] ?? ['429', '500', '502', '503', '504'];
        return in_array((string) $statusCode, $retryCodes, true);
    }

    protected function calculateMaxRetries(array $config): int
    {
        if (($config['strategy'] ?? 'none') === 'none') {
            return 0;
        }
        // Calculate max retries based on max_elapsed_time
        $maxElapsed = $config['max_elapsed_time'] ?? 3600000;
        $initial = $config['initial_interval'] ?? 500;
        $exponent = $config['exponent'] ?? 1.5;

        $total = 0;
        $interval = $initial;
        $retries = 0;

        while ($total < $maxElapsed && $retries < 10) {
            $total += $interval;
            $interval = min($interval * $exponent, $config['max_interval'] ?? 60000);
            $retries++;
        }

        return $retries;
    }

    protected function calculateBackoff(array $config, int $attempt): int
    {
        $initial = $config['initial_interval'] ?? 500;
        $exponent = $config['exponent'] ?? 1.5;
        $max = $config['max_interval'] ?? 60000;

        $delay = $initial * pow($exponent, $attempt - 1);
        // Add jitter (±25%)
        $jitter = $delay * 0.25 * (mt_rand() / mt_getrandmax() * 2 - 1);

        return (int) min($delay + $jitter, $max);
    }

    protected function sleep(int $milliseconds): void
    {
        usleep($milliseconds * 1000);
    }
}
