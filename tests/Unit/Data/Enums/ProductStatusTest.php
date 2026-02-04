<?php

use Creem\Data\Enums\ProductStatus;

test('product status has all expected values', function () {
    expect(ProductStatus::cases())->toHaveCount(2);
    expect(ProductStatus::Active->value)->toBe('active');
    expect(ProductStatus::Archived->value)->toBe('archived');
});

test('product status can be created from string', function () {
    expect(ProductStatus::from('active'))->toBe(ProductStatus::Active);
    expect(ProductStatus::from('archived'))->toBe(ProductStatus::Archived);
});

test('product status tryFrom returns null for invalid value', function () {
    expect(ProductStatus::tryFrom('invalid'))->toBeNull();
});
