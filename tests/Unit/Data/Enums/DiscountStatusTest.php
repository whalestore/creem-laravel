<?php

use Creem\Data\Enums\DiscountStatus;

test('discount status has all expected values', function () {
    expect(DiscountStatus::cases())->toHaveCount(4);
    expect(DiscountStatus::Active->value)->toBe('active');
    expect(DiscountStatus::Draft->value)->toBe('draft');
    expect(DiscountStatus::Expired->value)->toBe('expired');
    expect(DiscountStatus::Scheduled->value)->toBe('scheduled');
});

test('discount status can be created from string', function () {
    expect(DiscountStatus::from('active'))->toBe(DiscountStatus::Active);
    expect(DiscountStatus::from('draft'))->toBe(DiscountStatus::Draft);
    expect(DiscountStatus::from('expired'))->toBe(DiscountStatus::Expired);
    expect(DiscountStatus::from('scheduled'))->toBe(DiscountStatus::Scheduled);
});
