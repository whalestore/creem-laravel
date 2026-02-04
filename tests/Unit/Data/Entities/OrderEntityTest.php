<?php

use Creem\Data\Entities\OrderEntity;
use Creem\Data\Enums\EnvironmentMode;
use Creem\Data\Enums\OrderStatus;
use Creem\Data\Enums\OrderType;

test('order entity can be created from array', function () {
    $data = [
        'id' => 'ord_123',
        'mode' => 'test',
        'object' => 'order',
        'product' => 'prod_123',
        'amount' => 5000,
        'currency' => 'USD',
        'status' => 'paid',
        'type' => 'recurring',
        'customer' => 'cust_123',
        'created_at' => '2024-01-01T00:00:00Z',
        'updated_at' => '2024-01-02T00:00:00Z',
    ];

    $order = OrderEntity::from($data);

    expect($order->id)->toBe('ord_123');
    expect($order->mode)->toBe(EnvironmentMode::Test);
    expect($order->product)->toBe('prod_123');
    expect($order->amount)->toBe(5000);
    expect($order->status)->toBe(OrderStatus::Paid);
    expect($order->type)->toBe(OrderType::Recurring);
    expect($order->customer)->toBe('cust_123');
});

test('order entity handles onetime type', function () {
    $data = [
        'id' => 'ord_456',
        'mode' => 'prod',
        'object' => 'order',
        'product' => 'prod_456',
        'amount' => 2000,
        'currency' => 'EUR',
        'status' => 'pending',
        'type' => 'onetime',
        'created_at' => '2024-01-01T00:00:00Z',
        'updated_at' => '2024-01-02T00:00:00Z',
    ];

    $order = OrderEntity::from($data);

    expect($order->status)->toBe(OrderStatus::Pending);
    expect($order->type)->toBe(OrderType::Onetime);
    expect($order->customer)->toBeNull();
});

test('order entity handles tax and discount fields', function () {
    $data = [
        'id' => 'ord_789',
        'mode' => 'test',
        'object' => 'order',
        'product' => 'prod_789',
        'amount' => 10000,
        'currency' => 'USD',
        'status' => 'paid',
        'type' => 'recurring',
        'sub_total' => 8500,
        'tax_amount' => 1500,
        'discount_amount' => 0,
        'created_at' => '2024-01-01T00:00:00Z',
        'updated_at' => '2024-01-02T00:00:00Z',
    ];

    $order = OrderEntity::from($data);

    expect($order->subTotal)->toBe(8500);
    expect($order->taxAmount)->toBe(1500);
    expect($order->discountAmount)->toBe(0);
});
