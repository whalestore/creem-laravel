<?php

use Creem\Data\Enums\CustomFieldType;

test('custom field type has all expected values', function () {
    expect(CustomFieldType::cases())->toHaveCount(2);
    expect(CustomFieldType::Text->value)->toBe('text');
    expect(CustomFieldType::Checkbox->value)->toBe('checkbox');
});

test('custom field type can be created from string', function () {
    expect(CustomFieldType::from('text'))->toBe(CustomFieldType::Text);
    expect(CustomFieldType::from('checkbox'))->toBe(CustomFieldType::Checkbox);
});
