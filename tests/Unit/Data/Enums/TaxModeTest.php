<?php

use Creem\Data\Enums\TaxMode;

test('tax mode has all expected values', function () {
    expect(TaxMode::cases())->toHaveCount(2);
    expect(TaxMode::Inclusive->value)->toBe('inclusive');
    expect(TaxMode::Exclusive->value)->toBe('exclusive');
});

test('tax mode can be created from string', function () {
    expect(TaxMode::from('inclusive'))->toBe(TaxMode::Inclusive);
    expect(TaxMode::from('exclusive'))->toBe(TaxMode::Exclusive);
});
