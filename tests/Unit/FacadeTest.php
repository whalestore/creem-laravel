<?php

use Creem\Facades\Creem;
use Creem\Creem as CreemClient;
use Creem\Resources\Products;
use Creem\Resources\Customers;
use Creem\Resources\Subscriptions;
use Creem\Resources\Checkouts;

test('creem facade resolves to creem instance', function () {
    config(['creem.api_key' => 'facade_test_key']);

    $client = Creem::getFacadeRoot();

    expect($client)->toBeInstanceOf(CreemClient::class);
});

test('creem facade provides access to products', function () {
    config(['creem.api_key' => 'facade_test_key']);

    $client = Creem::getFacadeRoot();
    
    expect($client->products)->toBeInstanceOf(Products::class);
});

test('creem facade provides access to customers', function () {
    config(['creem.api_key' => 'facade_test_key']);

    $client = Creem::getFacadeRoot();
    
    expect($client->customers)->toBeInstanceOf(Customers::class);
});

test('creem facade provides access to subscriptions', function () {
    config(['creem.api_key' => 'facade_test_key']);

    $client = Creem::getFacadeRoot();
    
    expect($client->subscriptions)->toBeInstanceOf(Subscriptions::class);
});

test('creem facade provides access to checkouts', function () {
    config(['creem.api_key' => 'facade_test_key']);

    $client = Creem::getFacadeRoot();
    
    expect($client->checkouts)->toBeInstanceOf(Checkouts::class);
});

test('creem facade returns same instance', function () {
    config(['creem.api_key' => 'facade_test_key']);

    $client1 = Creem::getFacadeRoot();
    $client2 = Creem::getFacadeRoot();

    expect($client1)->toBe($client2);
});
