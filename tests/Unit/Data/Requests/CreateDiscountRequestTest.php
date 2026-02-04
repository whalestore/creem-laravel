<?php

use Creem\Data\Requests\CreateDiscountRequest;
use Creem\Data\Enums\DiscountType;
use Creem\Data\Enums\CouponDurationType;

test('create discount request with percentage type', function () {
    $request = new CreateDiscountRequest(
        name: 'Summer Sale',
        code: 'SUMMER20',
        type: DiscountType::Percentage,
        percentage: 20.0,
    );

    expect($request->name)->toBe('Summer Sale');
    expect($request->code)->toBe('SUMMER20');
    expect($request->type)->toBe(DiscountType::Percentage);
    expect($request->percentage)->toBe(20.0);
});

test('create discount request with fixed type', function () {
    $request = new CreateDiscountRequest(
        name: 'Flat Discount',
        code: 'FLAT10',
        type: DiscountType::Fixed,
        amount: 1000,
        currency: 'USD',
    );

    expect($request->type)->toBe(DiscountType::Fixed);
    expect($request->amount)->toBe(1000);
    expect($request->currency)->toBe('USD');
});

test('create discount request with duration', function () {
    $request = new CreateDiscountRequest(
        name: 'Repeating Discount',
        code: 'REPEAT',
        type: DiscountType::Percentage,
        percentage: 10.0,
        duration: CouponDurationType::Repeating,
        durationInMonths: 3,
    );

    expect($request->duration)->toBe(CouponDurationType::Repeating);
    expect($request->durationInMonths)->toBe(3);
});

test('create discount request serializes to array', function () {
    $request = new CreateDiscountRequest(
        name: 'Test',
        code: 'TEST',
        type: DiscountType::Percentage,
        percentage: 15.0,
        maxRedemptions: 100,
    );

    $array = $request->toArray();

    expect($array)->toHaveKey('max_redemptions');
    expect($array['max_redemptions'])->toBe(100);
});
