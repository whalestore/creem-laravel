<?php

use Creem\Data\Enums\OrderStatus;

test('order status has all expected values', function () {
    expect(OrderStatus::cases())->toHaveCount(2);
    expect(OrderStatus::Pending->value)->toBe('pending');
    expect(OrderStatus::Paid->value)->toBe('paid');
});

test('order status can be created from string', function () {
    expect(OrderStatus::from('pending'))->toBe(OrderStatus::Pending);
    expect(OrderStatus::from('paid'))->toBe(OrderStatus::Paid);
});
