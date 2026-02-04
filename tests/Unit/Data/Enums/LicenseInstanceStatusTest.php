<?php

use Creem\Data\Enums\LicenseInstanceStatus;

test('license instance status has all expected values', function () {
    expect(LicenseInstanceStatus::cases())->toHaveCount(2);
    expect(LicenseInstanceStatus::Active->value)->toBe('active');
    expect(LicenseInstanceStatus::Deactivated->value)->toBe('deactivated');
});

test('license instance status can be created from string', function () {
    expect(LicenseInstanceStatus::from('active'))->toBe(LicenseInstanceStatus::Active);
    expect(LicenseInstanceStatus::from('deactivated'))->toBe(LicenseInstanceStatus::Deactivated);
});
