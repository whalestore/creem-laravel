<?php

use Creem\Exceptions\AuthenticationException;

test('authentication exception has 401 status code', function () {
    $exception = new AuthenticationException();

    expect($exception->getMessage())->toBe('Authentication failed');
    expect($exception->getStatusCode())->toBe(401);
});

test('authentication exception with custom message', function () {
    $exception = new AuthenticationException('Invalid API key');

    expect($exception->getMessage())->toBe('Invalid API key');
    expect($exception->getStatusCode())->toBe(401);
});
