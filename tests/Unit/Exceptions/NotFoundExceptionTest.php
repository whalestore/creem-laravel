<?php

use Creem\Exceptions\NotFoundException;

test('not found exception has 404 status code', function () {
    $exception = new NotFoundException();

    expect($exception->getMessage())->toBe('Resource not found');
    expect($exception->getStatusCode())->toBe(404);
});

test('not found exception with custom message', function () {
    $exception = new NotFoundException('Product not found');

    expect($exception->getMessage())->toBe('Product not found');
    expect($exception->getStatusCode())->toBe(404);
});
