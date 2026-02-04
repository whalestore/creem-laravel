<?php

use Creem\Data\Entities\SubscriptionEntity;
use Creem\Data\Enums\EnvironmentMode;
use Creem\Data\Enums\SubscriptionStatus;

test('subscription entity can be created from array', function () {
    $data = [
        'id' => 'sub_123',
        'mode' => 'test',
        'object' => 'subscription',
        'status' => 'active',
        'quantity' => 1,
        'current_period_start' => 1704067200,
        'current_period_end' => 1706745600,
    ];

    $subscription = SubscriptionEntity::from($data);

    expect($subscription->id)->toBe('sub_123');
    expect($subscription->mode)->toBe(EnvironmentMode::Test);
    expect($subscription->status)->toBe(SubscriptionStatus::Active);
    expect($subscription->quantity)->toBe(1);
});

test('subscription entity handles canceled status', function () {
    $data = [
        'id' => 'sub_456',
        'mode' => 'prod',
        'object' => 'subscription',
        'status' => 'canceled',
        'canceled_at' => 1704067200,
    ];

    $subscription = SubscriptionEntity::from($data);

    expect($subscription->status)->toBe(SubscriptionStatus::Canceled);
    expect($subscription->canceledAt)->toBe(1704067200);
});

test('subscription entity handles paused status', function () {
    $data = [
        'id' => 'sub_789',
        'mode' => 'test',
        'object' => 'subscription',
        'status' => 'paused',
        'paused_at' => 1704067200,
        'resume_at' => 1706745600,
    ];

    $subscription = SubscriptionEntity::from($data);

    expect($subscription->status)->toBe(SubscriptionStatus::Paused);
    expect($subscription->pausedAt)->toBe(1704067200);
    expect($subscription->resumeAt)->toBe(1706745600);
});

test('subscription entity handles trialing status', function () {
    $data = [
        'id' => 'sub_trial',
        'mode' => 'test',
        'object' => 'subscription',
        'status' => 'trialing',
        'trial_start' => 1704067200,
        'trial_end' => 1705363200,
    ];

    $subscription = SubscriptionEntity::from($data);

    expect($subscription->status)->toBe(SubscriptionStatus::Trialing);
    expect($subscription->trialStart)->toBe(1704067200);
    expect($subscription->trialEnd)->toBe(1705363200);
});
