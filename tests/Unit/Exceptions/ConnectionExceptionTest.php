<?php

use Creem\Exceptions\ConnectionException;

test('connection exception has no status code', function () {
    $exception = new ConnectionException();

    expect($exception->getMessage())->toBe('Connection failed');
    expect($exception->getStatusCode())->toBeNull();
});

test('connection exception with custom message', function () {
    $exception = new ConnectionException('Could not connect to API server');

    expect($exception->getMessage())->toBe('Could not connect to API server');
});

test('connection exception with previous exception', function () {
    $previous = new \Exception('Network error');
    $exception = new ConnectionException('Connection failed', $previous);

    expect($exception->getPrevious())->toBe($previous);
});
