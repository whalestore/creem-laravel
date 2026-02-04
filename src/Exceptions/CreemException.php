<?php

namespace Creem\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

class CreemException extends Exception
{
    protected ?int $statusCode;
    protected mixed $body;
    protected array $headers;
    protected ?ResponseInterface $response;

    public function __construct(
        string $message = '',
        ?int $statusCode = null,
        mixed $body = null,
        array $headers = [],
        ?ResponseInterface $response = null,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode ?? 0, $previous);
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
        $this->response = $response;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function getBody(): mixed
    {
        return $this->body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
