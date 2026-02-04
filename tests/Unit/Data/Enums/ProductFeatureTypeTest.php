<?php

use Creem\Data\Enums\ProductFeatureType;

test('product feature type has all expected values', function () {
    expect(ProductFeatureType::cases())->toHaveCount(3);
    expect(ProductFeatureType::Custom->value)->toBe('custom');
    expect(ProductFeatureType::File->value)->toBe('file');
    expect(ProductFeatureType::LicenseKey->value)->toBe('licenseKey');
});

test('product feature type can be created from string', function () {
    expect(ProductFeatureType::from('custom'))->toBe(ProductFeatureType::Custom);
    expect(ProductFeatureType::from('file'))->toBe(ProductFeatureType::File);
    expect(ProductFeatureType::from('licenseKey'))->toBe(ProductFeatureType::LicenseKey);
});
