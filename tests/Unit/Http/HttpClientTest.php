<?php

use Creem\Http\HttpClient;
use Creem\Exceptions\AuthenticationException;
use Creem\Exceptions\NotFoundException;
use Creem\Exceptions\RateLimitException;
use Creem\Exceptions\ValidationException;
use Creem\Exceptions\ConnectionException;

test('http client can be instantiated with config', function () {
    $client = new HttpClient([
        'api_key' => 'test_api_key',
        'environment' => 'sandbox',
    ]);

    expect($client)->toBeInstanceOf(HttpClient::class);
});

test('http client handles empty config', function () {
    $client = new HttpClient([]);

    expect($client)->toBeInstanceOf(HttpClient::class);
});

test('http client with timeout config', function () {
    $client = new HttpClient([
        'api_key' => 'test_key',
        'timeout' => 60,
    ]);

    expect($client)->toBeInstanceOf(HttpClient::class);
});

test('http client with retry config', function () {
    $client = new HttpClient([
        'api_key' => 'test_key',
        'retry' => [
            'strategy' => 'backoff',
            'max_elapsed_time' => 60000,
            'initial_interval' => 500,
        ],
    ]);

    expect($client)->toBeInstanceOf(HttpClient::class);
});

test('http client with base url config', function () {
    $client = new HttpClient([
        'api_key' => 'test_key',
        'base_url' => [
            'production' => 'https://api.creem.io',
            'sandbox' => 'https://api.sandbox.creem.io',
        ],
    ]);

    expect($client)->toBeInstanceOf(HttpClient::class);
});
