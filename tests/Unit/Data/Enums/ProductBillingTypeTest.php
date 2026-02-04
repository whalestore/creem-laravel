<?php

use Creem\Data\Enums\ProductBillingType;

test('product billing type has all expected values', function () {
    expect(ProductBillingType::cases())->toHaveCount(2);
    expect(ProductBillingType::Recurring->value)->toBe('recurring');
    expect(ProductBillingType::Onetime->value)->toBe('onetime');
});

test('product billing type can be created from string', function () {
    expect(ProductBillingType::from('recurring'))->toBe(ProductBillingType::Recurring);
    expect(ProductBillingType::from('onetime'))->toBe(ProductBillingType::Onetime);
});
