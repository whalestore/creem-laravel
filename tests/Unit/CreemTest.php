<?php

use Creem\Creem;
use Creem\Resources\Products;
use Creem\Resources\Customers;
use Creem\Resources\Subscriptions;
use Creem\Resources\Checkouts;
use Creem\Resources\Licenses;
use Creem\Resources\Discounts;
use Creem\Resources\Transactions;

test('creem client can be instantiated with config', function () {
    $creem = new Creem([
        'api_key' => 'test_api_key',
        'environment' => 'sandbox',
    ]);

    expect($creem)->toBeInstanceOf(Creem::class);
});

test('creem client has products resource', function () {
    $creem = new Creem(['api_key' => 'test_api_key']);

    expect($creem->products)->toBeInstanceOf(Products::class);
});

test('creem client has customers resource', function () {
    $creem = new Creem(['api_key' => 'test_api_key']);

    expect($creem->customers)->toBeInstanceOf(Customers::class);
});

test('creem client has subscriptions resource', function () {
    $creem = new Creem(['api_key' => 'test_api_key']);

    expect($creem->subscriptions)->toBeInstanceOf(Subscriptions::class);
});

test('creem client has checkouts resource', function () {
    $creem = new Creem(['api_key' => 'test_api_key']);

    expect($creem->checkouts)->toBeInstanceOf(Checkouts::class);
});

test('creem client has licenses resource', function () {
    $creem = new Creem(['api_key' => 'test_api_key']);

    expect($creem->licenses)->toBeInstanceOf(Licenses::class);
});

test('creem client has discounts resource', function () {
    $creem = new Creem(['api_key' => 'test_api_key']);

    expect($creem->discounts)->toBeInstanceOf(Discounts::class);
});

test('creem client has transactions resource', function () {
    $creem = new Creem(['api_key' => 'test_api_key']);

    expect($creem->transactions)->toBeInstanceOf(Transactions::class);
});

test('creem client can be configured with environment', function () {
    $creem = new Creem([
        'api_key' => 'test_api_key',
        'environment' => 'sandbox',
    ]);

    expect($creem)->toBeInstanceOf(Creem::class);
});

test('creem client accepts custom base url', function () {
    $creem = new Creem([
        'api_key' => 'test_api_key',
        'base_url' => 'https://custom.api.com',
    ]);

    expect($creem)->toBeInstanceOf(Creem::class);
});

test('creem client can get http client', function () {
    $creem = new Creem(['api_key' => 'test_api_key']);

    expect($creem->getClient())->toBeInstanceOf(\Creem\Http\HttpClient::class);
});
