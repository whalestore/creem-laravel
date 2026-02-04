<?php

use Creem\Exceptions\ValidationException;

test('validation exception has 400 status code', function () {
    $exception = new ValidationException();

    expect($exception->getMessage())->toBe('Validation failed');
    expect($exception->getStatusCode())->toBe(400);
});

test('validation exception with custom message', function () {
    $exception = new ValidationException('Invalid input data');

    expect($exception->getMessage())->toBe('Invalid input data');
    expect($exception->getStatusCode())->toBe(400);
});

test('validation exception with body', function () {
    $exception = new ValidationException(
        message: 'Validation error',
        body: ['field' => 'email', 'error' => 'Invalid format'],
    );

    expect($exception->getBody())->toBe(['field' => 'email', 'error' => 'Invalid format']);
});
