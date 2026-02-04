<?php

use Creem\Data\Entities\LicenseEntity;
use Creem\Data\Enums\EnvironmentMode;
use Creem\Data\Enums\LicenseStatus;

test('license entity can be created from array', function () {
    $data = [
        'id' => 'lic_123',
        'mode' => 'test',
        'object' => 'license',
        'status' => 'active',
        'key' => 'XXXX-XXXX-XXXX-XXXX',
        'activation' => 1,
        'activation_limit' => 5,
        'created_at' => '2024-01-01T00:00:00Z',
    ];

    $license = LicenseEntity::from($data);

    expect($license->id)->toBe('lic_123');
    expect($license->mode)->toBe(EnvironmentMode::Test);
    expect($license->status)->toBe(LicenseStatus::Active);
    expect($license->key)->toBe('XXXX-XXXX-XXXX-XXXX');
    expect($license->activation)->toBe(1);
    expect($license->activationLimit)->toBe(5);
});

test('license entity handles inactive status', function () {
    $data = [
        'id' => 'lic_456',
        'mode' => 'prod',
        'object' => 'license',
        'status' => 'inactive',
        'key' => 'YYYY-YYYY-YYYY-YYYY',
        'activation' => 0,
        'created_at' => '2024-01-01T00:00:00Z',
    ];

    $license = LicenseEntity::from($data);

    expect($license->status)->toBe(LicenseStatus::Inactive);
    expect($license->activation)->toBe(0);
    expect($license->activationLimit)->toBeNull();
});

test('license entity handles expired status', function () {
    $data = [
        'id' => 'lic_789',
        'mode' => 'test',
        'object' => 'license',
        'status' => 'expired',
        'key' => 'ZZZZ-ZZZZ-ZZZZ-ZZZZ',
        'activation' => 3,
        'created_at' => '2024-01-01T00:00:00Z',
        'expires_at' => '2024-12-31T23:59:59Z',
    ];

    $license = LicenseEntity::from($data);

    expect($license->status)->toBe(LicenseStatus::Expired);
    expect($license->expiresAt)->toBeInstanceOf(DateTime::class);
});
