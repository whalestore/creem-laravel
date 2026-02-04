<?php

use Creem\Exceptions\TimeoutException;

test('timeout exception has no status code', function () {
    $exception = new TimeoutException();

    expect($exception->getMessage())->toBe('Request timed out');
    expect($exception->getStatusCode())->toBeNull();
});

test('timeout exception with custom message', function () {
    $exception = new TimeoutException('Request took too long');

    expect($exception->getMessage())->toBe('Request took too long');
});

test('timeout exception with previous exception', function () {
    $previous = new \Exception('cURL timeout');
    $exception = new TimeoutException('Timed out', $previous);

    expect($exception->getPrevious())->toBe($previous);
});
