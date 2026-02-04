<?php

use Creem\Data\Entities\CheckoutEntity;
use Creem\Data\Enums\EnvironmentMode;
use Creem\Data\Enums\CheckoutStatus;

test('checkout entity can be created from array', function () {
    $data = [
        'id' => 'ch_123',
        'mode' => 'test',
        'object' => 'checkout',
        'status' => 'pending',
        'checkout_url' => 'https://checkout.creem.io/ch_123',
        'success_url' => 'https://example.com/success',
    ];

    $checkout = CheckoutEntity::from($data);

    expect($checkout->id)->toBe('ch_123');
    expect($checkout->mode)->toBe(EnvironmentMode::Test);
    expect($checkout->status)->toBe(CheckoutStatus::Pending);
    expect($checkout->checkoutUrl)->toBe('https://checkout.creem.io/ch_123');
    expect($checkout->successUrl)->toBe('https://example.com/success');
});

test('checkout entity handles completed status', function () {
    $data = [
        'id' => 'ch_456',
        'mode' => 'prod',
        'object' => 'checkout',
        'status' => 'completed',
        'checkout_url' => 'https://checkout.creem.io/ch_456',
        'created_at' => 1704067200,
        'updated_at' => 1704070800,
    ];

    $checkout = CheckoutEntity::from($data);

    expect($checkout->status)->toBe(CheckoutStatus::Completed);
    expect($checkout->createdAt)->toBe(1704067200);
    expect($checkout->updatedAt)->toBe(1704070800);
});

test('checkout entity handles expired status', function () {
    $data = [
        'id' => 'ch_789',
        'mode' => 'test',
        'object' => 'checkout',
        'status' => 'expired',
        'checkout_url' => 'https://checkout.creem.io/ch_789',
        'expires_at' => 1704067200,
    ];

    $checkout = CheckoutEntity::from($data);

    expect($checkout->status)->toBe(CheckoutStatus::Expired);
    expect($checkout->expiresAt)->toBe(1704067200);
});

test('checkout entity handles metadata', function () {
    $data = [
        'id' => 'ch_meta',
        'mode' => 'test',
        'object' => 'checkout',
        'status' => 'pending',
        'checkout_url' => 'https://checkout.creem.io/ch_meta',
        'metadata' => ['user_id' => '123', 'plan' => 'pro'],
    ];

    $checkout = CheckoutEntity::from($data);

    expect($checkout->metadata)->toBe(['user_id' => '123', 'plan' => 'pro']);
});
