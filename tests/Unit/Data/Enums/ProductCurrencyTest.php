<?php

use Creem\Data\Enums\ProductCurrency;

test('product currency has all expected values', function () {
    expect(ProductCurrency::cases())->toHaveCount(2);
    expect(ProductCurrency::EUR->value)->toBe('EUR');
    expect(ProductCurrency::USD->value)->toBe('USD');
});

test('product currency can be created from string', function () {
    expect(ProductCurrency::from('EUR'))->toBe(ProductCurrency::EUR);
    expect(ProductCurrency::from('USD'))->toBe(ProductCurrency::USD);
});
