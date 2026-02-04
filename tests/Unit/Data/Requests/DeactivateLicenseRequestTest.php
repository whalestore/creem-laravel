<?php

use Creem\Data\Requests\DeactivateLicenseRequest;

test('deactivate license request with required fields', function () {
    $request = new DeactivateLicenseRequest(
        key: 'XXXX-XXXX-XXXX-XXXX',
        instanceId: 'inst_123',
    );

    expect($request->key)->toBe('XXXX-XXXX-XXXX-XXXX');
    expect($request->instanceId)->toBe('inst_123');
});

test('deactivate license request serializes to array', function () {
    $request = new DeactivateLicenseRequest(
        key: 'TEST-KEY',
        instanceId: 'inst_456',
    );

    $array = $request->toArray();

    expect($array)->toHaveKey('key');
    expect($array)->toHaveKey('instance_id');
    expect($array['instance_id'])->toBe('inst_456');
});
