<?php

use Creem\Data\Enums\TaxCategory;

test('tax category has all expected values', function () {
    expect(TaxCategory::cases())->toHaveCount(3);
    expect(TaxCategory::Saas->value)->toBe('saas');
    expect(TaxCategory::DigitalGoodsService->value)->toBe('digital-goods-service');
    expect(TaxCategory::Ebooks->value)->toBe('ebooks');
});

test('tax category can be created from string', function () {
    expect(TaxCategory::from('saas'))->toBe(TaxCategory::Saas);
    expect(TaxCategory::from('digital-goods-service'))->toBe(TaxCategory::DigitalGoodsService);
    expect(TaxCategory::from('ebooks'))->toBe(TaxCategory::Ebooks);
});
