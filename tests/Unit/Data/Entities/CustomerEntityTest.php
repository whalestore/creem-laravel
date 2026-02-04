<?php

use Creem\Data\Entities\CustomerEntity;
use Creem\Data\Enums\EnvironmentMode;

test('customer entity can be created from array', function () {
    $data = [
        'id' => 'cust_123',
        'mode' => 'test',
        'object' => 'customer',
        'email' => 'test@example.com',
        'name' => 'Test Customer',
        'country' => 'US',
        'created_at' => '2024-01-01T00:00:00Z',
        'updated_at' => '2024-01-02T00:00:00Z',
    ];

    $customer = CustomerEntity::from($data);

    expect($customer->id)->toBe('cust_123');
    expect($customer->mode)->toBe(EnvironmentMode::Test);
    expect($customer->email)->toBe('test@example.com');
    expect($customer->name)->toBe('Test Customer');
    expect($customer->country)->toBe('US');
});

test('customer entity handles optional name field', function () {
    $data = [
        'id' => 'cust_123',
        'mode' => 'prod',
        'object' => 'customer',
        'email' => 'test@example.com',
        'country' => 'DE',
        'created_at' => '2024-01-01T00:00:00Z',
        'updated_at' => '2024-01-02T00:00:00Z',
    ];

    $customer = CustomerEntity::from($data);

    expect($customer->name)->toBeNull();
    expect($customer->mode)->toBe(EnvironmentMode::Prod);
});

test('customer entity serializes to array', function () {
    $customer = new CustomerEntity(
        id: 'cust_123',
        mode: EnvironmentMode::Test,
        object: 'customer',
        email: 'test@example.com',
        country: 'US',
        createdAt: new DateTime('2024-01-01'),
        updatedAt: new DateTime('2024-01-02'),
        name: 'Test',
    );

    $array = $customer->toArray();

    expect($array)->toHaveKey('created_at');
    expect($array['mode'])->toBe('test');
});
