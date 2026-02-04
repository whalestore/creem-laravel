<?php

use Creem\Data\Requests\ActivateLicenseRequest;

test('activate license request with required fields', function () {
    $request = new ActivateLicenseRequest(
        key: 'XXXX-XXXX-XXXX-XXXX',
        instanceName: 'My MacBook Pro',
    );

    expect($request->key)->toBe('XXXX-XXXX-XXXX-XXXX');
    expect($request->instanceName)->toBe('My MacBook Pro');
});

test('activate license request serializes to array', function () {
    $request = new ActivateLicenseRequest(
        key: 'TEST-KEY',
        instanceName: 'Test Device',
    );

    $array = $request->toArray();

    expect($array)->toHaveKey('key');
    expect($array)->toHaveKey('instance_name');
    expect($array['instance_name'])->toBe('Test Device');
});
