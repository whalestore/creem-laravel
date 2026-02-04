<?php

use Creem\Data\Enums\DiscountType;

test('discount type has all expected values', function () {
    expect(DiscountType::cases())->toHaveCount(2);
    expect(DiscountType::Percentage->value)->toBe('percentage');
    expect(DiscountType::Fixed->value)->toBe('fixed');
});

test('discount type can be created from string', function () {
    expect(DiscountType::from('percentage'))->toBe(DiscountType::Percentage);
    expect(DiscountType::from('fixed'))->toBe(DiscountType::Fixed);
});
