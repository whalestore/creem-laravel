<?php

use Creem\Data\Requests\CustomerRequest;

test('customer request can be created with required email', function () {
    $request = new CustomerRequest(
        email: 'test@example.com',
    );

    expect($request->email)->toBe('test@example.com');
    expect($request->name)->toBeNull();
    expect($request->country)->toBeNull();
});

test('customer request can include optional fields', function () {
    $request = new CustomerRequest(
        email: 'test@example.com',
        name: 'Test Customer',
        country: 'US',
    );

    expect($request->email)->toBe('test@example.com');
    expect($request->name)->toBe('Test Customer');
    expect($request->country)->toBe('US');
});

test('customer request serializes to array', function () {
    $request = new CustomerRequest(
        email: 'test@example.com',
        name: 'Test',
        country: 'DE',
    );

    $array = $request->toArray();

    expect($array['email'])->toBe('test@example.com');
    expect($array['name'])->toBe('Test');
    expect($array['country'])->toBe('DE');
});
