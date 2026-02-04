<?php

use Creem\Data\Enums\SubscriptionStatus;

test('subscription status has all expected values', function () {
    expect(SubscriptionStatus::cases())->toHaveCount(6);
    expect(SubscriptionStatus::Active->value)->toBe('active');
    expect(SubscriptionStatus::Canceled->value)->toBe('canceled');
    expect(SubscriptionStatus::Unpaid->value)->toBe('unpaid');
    expect(SubscriptionStatus::Paused->value)->toBe('paused');
    expect(SubscriptionStatus::Trialing->value)->toBe('trialing');
    expect(SubscriptionStatus::ScheduledCancel->value)->toBe('scheduled_cancel');
});

test('subscription status can be created from string', function () {
    expect(SubscriptionStatus::from('active'))->toBe(SubscriptionStatus::Active);
    expect(SubscriptionStatus::from('canceled'))->toBe(SubscriptionStatus::Canceled);
    expect(SubscriptionStatus::from('scheduled_cancel'))->toBe(SubscriptionStatus::ScheduledCancel);
});
