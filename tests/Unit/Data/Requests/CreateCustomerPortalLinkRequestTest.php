<?php

use Creem\Data\Requests\CreateCustomerPortalLinkRequest;

test('create customer portal link request with required customer id', function () {
    $request = new CreateCustomerPortalLinkRequest(
        customerId: 'cust_123',
    );

    expect($request->customerId)->toBe('cust_123');
    expect($request->returnUrl)->toBeNull();
});

test('create customer portal link request with return url', function () {
    $request = new CreateCustomerPortalLinkRequest(
        customerId: 'cust_456',
        returnUrl: 'https://example.com/account',
    );

    expect($request->customerId)->toBe('cust_456');
    expect($request->returnUrl)->toBe('https://example.com/account');
});

test('create customer portal link request serializes to array', function () {
    $request = new CreateCustomerPortalLinkRequest(
        customerId: 'cust_789',
        returnUrl: 'https://example.com',
    );

    $array = $request->toArray();

    expect($array)->toHaveKey('customer_id');
    expect($array)->toHaveKey('return_url');
});
