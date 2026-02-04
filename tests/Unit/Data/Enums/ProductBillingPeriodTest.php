<?php

use Creem\Data\Enums\ProductBillingPeriod;

test('product billing period has all expected values', function () {
    expect(ProductBillingPeriod::cases())->toHaveCount(5);
    expect(ProductBillingPeriod::EveryMonth->value)->toBe('every-month');
    expect(ProductBillingPeriod::EveryThreeMonths->value)->toBe('every-three-months');
    expect(ProductBillingPeriod::EverySixMonths->value)->toBe('every-six-months');
    expect(ProductBillingPeriod::EveryYear->value)->toBe('every-year');
    expect(ProductBillingPeriod::Once->value)->toBe('once');
});
