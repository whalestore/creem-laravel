<?php

use Creem\Data\Enums\CouponDurationType;

test('coupon duration type has all expected values', function () {
    expect(CouponDurationType::cases())->toHaveCount(3);
    expect(CouponDurationType::Forever->value)->toBe('forever');
    expect(CouponDurationType::Once->value)->toBe('once');
    expect(CouponDurationType::Repeating->value)->toBe('repeating');
});

test('coupon duration type can be created from string', function () {
    expect(CouponDurationType::from('forever'))->toBe(CouponDurationType::Forever);
    expect(CouponDurationType::from('once'))->toBe(CouponDurationType::Once);
    expect(CouponDurationType::from('repeating'))->toBe(CouponDurationType::Repeating);
});
