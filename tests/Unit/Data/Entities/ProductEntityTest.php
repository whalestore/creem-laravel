<?php

use Creem\Data\Entities\ProductEntity;
use Creem\Data\Enums\EnvironmentMode;
use Creem\Data\Enums\ProductBillingType;
use Creem\Data\Enums\ProductBillingPeriod;
use Creem\Data\Enums\ProductStatus;

test('product entity can be created from array', function () {
    $data = [
        'id' => 'prod_123',
        'mode' => 'test',
        'object' => 'product',
        'name' => 'Test Product',
        'description' => 'A test product',
        'image_url' => 'https://example.com/image.png',
        'price' => 1000,
        'currency' => 'USD',
        'billing_type' => 'recurring',
        'billing_period' => 'every-month',
        'status' => 'active',
        'tax_mode' => 'exclusive',
        'tax_category' => 'saas',
        'created_at' => '2024-01-01T00:00:00Z',
        'updated_at' => '2024-01-02T00:00:00Z',
    ];

    $product = ProductEntity::from($data);

    expect($product->id)->toBe('prod_123');
    expect($product->mode)->toBe(EnvironmentMode::Test);
    expect($product->name)->toBe('Test Product');
    expect($product->price)->toBe(1000);
    expect($product->billingType)->toBe(ProductBillingType::Recurring);
    expect($product->billingPeriod)->toBe(ProductBillingPeriod::EveryMonth);
    expect($product->status)->toBe(ProductStatus::Active);
});

test('product entity handles optional fields', function () {
    $data = [
        'id' => 'prod_123',
        'mode' => 'prod',
        'object' => 'product',
        'name' => 'Test Product',
        'price' => 1000,
        'currency' => 'USD',
        'billing_type' => 'onetime',
        'status' => 'active',
        'created_at' => '2024-01-01T00:00:00Z',
        'updated_at' => '2024-01-02T00:00:00Z',
    ];

    $product = ProductEntity::from($data);

    expect($product->description)->toBeNull();
    expect($product->imageUrl)->toBeNull();
    expect($product->billingPeriod)->toBeNull();
});

test('product entity serializes to array with snake_case keys', function () {
    $product = new ProductEntity(
        id: 'prod_123',
        mode: EnvironmentMode::Test,
        object: 'product',
        name: 'Test Product',
        price: 1000,
        currency: 'USD',
        billingType: ProductBillingType::Recurring,
        status: ProductStatus::Active,
        createdAt: new DateTime('2024-01-01'),
        updatedAt: new DateTime('2024-01-02'),
    );

    $array = $product->toArray();

    expect($array)->toHaveKey('billing_type');
    expect($array['billing_type'])->toBe('recurring');
});
