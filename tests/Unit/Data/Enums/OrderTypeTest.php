<?php

use Creem\Data\Enums\OrderType;

test('order type has all expected values', function () {
    expect(OrderType::cases())->toHaveCount(2);
    expect(OrderType::Recurring->value)->toBe('recurring');
    expect(OrderType::Onetime->value)->toBe('onetime');
});

test('order type can be created from string', function () {
    expect(OrderType::from('recurring'))->toBe(OrderType::Recurring);
    expect(OrderType::from('onetime'))->toBe(OrderType::Onetime);
});
