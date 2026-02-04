<?php

use Creem\Data\Entities\LicenseInstanceEntity;
use Creem\Data\Enums\EnvironmentMode;

test('license instance entity can be created from array', function () {
    $data = [
        'id' => 'inst_123',
        'mode' => 'test',
        'object' => 'license_instance',
        'name' => 'My MacBook Pro',
        'status' => 'active',
        'created_at' => '2024-01-01T00:00:00Z',
    ];

    $instance = LicenseInstanceEntity::from($data);

    expect($instance->id)->toBe('inst_123');
    expect($instance->mode)->toBe(EnvironmentMode::Test);
    expect($instance->name)->toBe('My MacBook Pro');
    expect($instance->status)->toBe('active');
});

test('license instance entity handles deactivated status', function () {
    $data = [
        'id' => 'inst_456',
        'mode' => 'prod',
        'object' => 'license_instance',
        'name' => 'Old Computer',
        'status' => 'deactivated',
        'created_at' => '2024-01-01T00:00:00Z',
    ];

    $instance = LicenseInstanceEntity::from($data);

    expect($instance->status)->toBe('deactivated');
});
