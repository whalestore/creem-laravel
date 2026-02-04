<?php

use Creem\Data\Enums\LicenseStatus;

test('license status has all expected values', function () {
    expect(LicenseStatus::cases())->toHaveCount(4);
    expect(LicenseStatus::Inactive->value)->toBe('inactive');
    expect(LicenseStatus::Active->value)->toBe('active');
    expect(LicenseStatus::Expired->value)->toBe('expired');
    expect(LicenseStatus::Disabled->value)->toBe('disabled');
});

test('license status can be created from string', function () {
    expect(LicenseStatus::from('inactive'))->toBe(LicenseStatus::Inactive);
    expect(LicenseStatus::from('active'))->toBe(LicenseStatus::Active);
    expect(LicenseStatus::from('expired'))->toBe(LicenseStatus::Expired);
    expect(LicenseStatus::from('disabled'))->toBe(LicenseStatus::Disabled);
});
