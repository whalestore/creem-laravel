<?php

use Creem\Exceptions\CreemException;
use GuzzleHttp\Psr7\Response;

test('creem exception can be created with message only', function () {
    $exception = new CreemException('Test error');

    expect($exception->getMessage())->toBe('Test error');
    expect($exception->getStatusCode())->toBeNull();
    expect($exception->getBody())->toBeNull();
    expect($exception->getHeaders())->toBe([]);
    expect($exception->getResponse())->toBeNull();
});

test('creem exception can be created with all properties', function () {
    $response = new Response(500, ['X-Request-Id' => '123'], 'Server error');
    
    $exception = new CreemException(
        message: 'Server error occurred',
        statusCode: 500,
        body: ['error' => 'Internal error'],
        headers: ['X-Request-Id' => '123'],
        response: $response,
    );

    expect($exception->getMessage())->toBe('Server error occurred');
    expect($exception->getStatusCode())->toBe(500);
    expect($exception->getBody())->toBe(['error' => 'Internal error']);
    expect($exception->getHeaders())->toBe(['X-Request-Id' => '123']);
    expect($exception->getResponse())->toBe($response);
});

test('creem exception code matches status code', function () {
    $exception = new CreemException('Error', 404);

    expect($exception->getCode())->toBe(404);
});
