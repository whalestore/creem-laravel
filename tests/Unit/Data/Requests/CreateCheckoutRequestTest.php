<?php

use Creem\Data\Requests\CreateCheckoutRequest;
use Creem\Data\Requests\CustomerRequest;

test('create checkout request can be created with required fields', function () {
    $request = new CreateCheckoutRequest(
        productId: 'prod_123',
        successUrl: 'https://example.com/success',
    );

    expect($request->productId)->toBe('prod_123');
    expect($request->successUrl)->toBe('https://example.com/success');
});

test('create checkout request can include optional fields', function () {
    $customer = new CustomerRequest(
        email: 'test@example.com',
        name: 'Test Customer',
    );

    $request = new CreateCheckoutRequest(
        productId: 'prod_123',
        successUrl: 'https://example.com/success',
        units: 2,
        customer: $customer,
        discountCode: 'SAVE20',
        requestId: 'req_123',
        metadata: ['key' => 'value'],
    );

    expect($request->units)->toBe(2);
    expect($request->customer)->toBe($customer);
    expect($request->discountCode)->toBe('SAVE20');
    expect($request->requestId)->toBe('req_123');
    expect($request->metadata)->toBe(['key' => 'value']);
});

test('create checkout request serializes to array with snake_case', function () {
    $request = new CreateCheckoutRequest(
        productId: 'prod_123',
        successUrl: 'https://example.com/success',
        discountCode: 'TEST',
    );

    $array = $request->toArray();

    expect($array)->toHaveKey('product_id');
    expect($array)->toHaveKey('success_url');
    expect($array)->toHaveKey('discount_code');
});
