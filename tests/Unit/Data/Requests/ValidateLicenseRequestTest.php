<?php

use Creem\Data\Requests\ValidateLicenseRequest;

test('validate license request with key only', function () {
    $request = new ValidateLicenseRequest(
        key: 'XXXX-XXXX-XXXX-XXXX',
    );

    expect($request->key)->toBe('XXXX-XXXX-XXXX-XXXX');
    expect($request->instanceId)->toBeNull();
});

test('validate license request with instance id', function () {
    $request = new ValidateLicenseRequest(
        key: 'YYYY-YYYY-YYYY-YYYY',
        instanceId: 'inst_123',
    );

    expect($request->key)->toBe('YYYY-YYYY-YYYY-YYYY');
    expect($request->instanceId)->toBe('inst_123');
});

test('validate license request serializes to array', function () {
    $request = new ValidateLicenseRequest(
        key: 'TEST-KEY',
        instanceId: 'inst_456',
    );

    $array = $request->toArray();

    expect($array)->toHaveKey('key');
    expect($array)->toHaveKey('instance_id');
});
