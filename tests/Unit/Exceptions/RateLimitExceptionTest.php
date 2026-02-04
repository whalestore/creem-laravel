<?php

use Creem\Exceptions\RateLimitException;

test('rate limit exception has 429 status code', function () {
    $exception = new RateLimitException();

    expect($exception->getMessage())->toBe('Rate limit exceeded');
    expect($exception->getStatusCode())->toBe(429);
});

test('rate limit exception with custom message', function () {
    $exception = new RateLimitException('Too many requests, please slow down');

    expect($exception->getMessage())->toBe('Too many requests, please slow down');
    expect($exception->getStatusCode())->toBe(429);
});

test('rate limit exception with headers', function () {
    $exception = new RateLimitException(
        message: 'Rate limited',
        headers: ['X-RateLimit-Remaining' => '0', 'Retry-After' => '60'],
    );

    expect($exception->getHeaders())->toHaveKey('Retry-After');
});
