<?php

use Creem\Data\Entities\DiscountEntity;
use Creem\Data\Enums\EnvironmentMode;
use Creem\Data\Enums\DiscountStatus;
use Creem\Data\Enums\DiscountType;
use Creem\Data\Enums\CouponDurationType;

test('discount entity can be created from array', function () {
    $data = [
        'id' => 'disc_123',
        'mode' => 'test',
        'object' => 'discount',
        'status' => 'active',
        'name' => 'Test Discount',
        'code' => 'SAVE20',
        'type' => 'percentage',
        'percentage' => 20.0,
        'max_redemptions' => 100,
    ];

    $discount = DiscountEntity::from($data);

    expect($discount->id)->toBe('disc_123');
    expect($discount->mode)->toBe(EnvironmentMode::Test);
    expect($discount->status)->toBe(DiscountStatus::Active);
    expect($discount->name)->toBe('Test Discount');
    expect($discount->code)->toBe('SAVE20');
    expect($discount->type)->toBe(DiscountType::Percentage);
    expect($discount->percentage)->toBe(20.0);
});

test('discount entity handles fixed type', function () {
    $data = [
        'id' => 'disc_456',
        'mode' => 'prod',
        'object' => 'discount',
        'status' => 'draft',
        'name' => 'Fixed Discount',
        'code' => 'FLAT10',
        'type' => 'fixed',
        'amount' => 1000,
        'currency' => 'USD',
    ];

    $discount = DiscountEntity::from($data);

    expect($discount->type)->toBe(DiscountType::Fixed);
    expect($discount->amount)->toBe(1000);
    expect($discount->currency)->toBe('USD');
    expect($discount->percentage)->toBeNull();
});

test('discount entity handles duration', function () {
    $data = [
        'id' => 'disc_789',
        'mode' => 'test',
        'object' => 'discount',
        'status' => 'active',
        'name' => 'Repeating Discount',
        'code' => 'REPEAT',
        'type' => 'percentage',
        'percentage' => 10.0,
        'duration' => 'repeating',
        'duration_in_months' => 3,
    ];

    $discount = DiscountEntity::from($data);

    expect($discount->duration)->toBe(CouponDurationType::Repeating);
    expect($discount->durationInMonths)->toBe(3);
});
