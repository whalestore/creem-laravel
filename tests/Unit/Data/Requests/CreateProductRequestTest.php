<?php

use Creem\Data\Requests\CreateProductRequest;
use Creem\Data\Enums\ProductCurrency;
use Creem\Data\Enums\ProductBillingType;
use Creem\Data\Enums\ProductBillingPeriod;
use Creem\Data\Enums\TaxMode;
use Creem\Data\Enums\TaxCategory;

test('create product request can be created with required fields', function () {
    $request = new CreateProductRequest(
        name: 'Test Product',
        price: 1000,
        currency: ProductCurrency::USD,
        billingType: ProductBillingType::Recurring,
    );

    expect($request->name)->toBe('Test Product');
    expect($request->price)->toBe(1000);
    expect($request->currency)->toBe(ProductCurrency::USD);
    expect($request->billingType)->toBe(ProductBillingType::Recurring);
});

test('create product request can include optional fields', function () {
    $request = new CreateProductRequest(
        name: 'Premium Product',
        price: 5000,
        currency: ProductCurrency::EUR,
        billingType: ProductBillingType::Recurring,
        description: 'A premium product',
        billingPeriod: ProductBillingPeriod::EveryMonth,
        taxMode: TaxMode::Exclusive,
        taxCategory: TaxCategory::Saas,
    );

    expect($request->description)->toBe('A premium product');
    expect($request->billingPeriod)->toBe(ProductBillingPeriod::EveryMonth);
    expect($request->taxMode)->toBe(TaxMode::Exclusive);
    expect($request->taxCategory)->toBe(TaxCategory::Saas);
});

test('create product request serializes to array with snake_case', function () {
    $request = new CreateProductRequest(
        name: 'Test',
        price: 1000,
        currency: ProductCurrency::USD,
        billingType: ProductBillingType::Onetime,
    );

    $array = $request->toArray();

    expect($array)->toHaveKey('billing_type');
    expect($array['billing_type'])->toBe('onetime');
});
