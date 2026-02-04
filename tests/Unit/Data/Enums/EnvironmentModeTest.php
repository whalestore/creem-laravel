<?php

use Creem\Data\Enums\EnvironmentMode;

test('environment mode has all expected values', function () {
    expect(EnvironmentMode::cases())->toHaveCount(3);
    expect(EnvironmentMode::Test->value)->toBe('test');
    expect(EnvironmentMode::Prod->value)->toBe('prod');
    expect(EnvironmentMode::Sandbox->value)->toBe('sandbox');
});

test('environment mode can be created from string', function () {
    expect(EnvironmentMode::from('test'))->toBe(EnvironmentMode::Test);
    expect(EnvironmentMode::from('prod'))->toBe(EnvironmentMode::Prod);
    expect(EnvironmentMode::from('sandbox'))->toBe(EnvironmentMode::Sandbox);
});

test('environment mode tryFrom returns null for invalid value', function () {
    expect(EnvironmentMode::tryFrom('invalid'))->toBeNull();
});
