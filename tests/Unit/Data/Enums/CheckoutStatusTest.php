<?php

use Creem\Data\Enums\CheckoutStatus;

test('checkout status has all expected values', function () {
    expect(CheckoutStatus::cases())->toHaveCount(4);
    expect(CheckoutStatus::Pending->value)->toBe('pending');
    expect(CheckoutStatus::Processing->value)->toBe('processing');
    expect(CheckoutStatus::Completed->value)->toBe('completed');
    expect(CheckoutStatus::Expired->value)->toBe('expired');
});

test('checkout status can be created from string', function () {
    expect(CheckoutStatus::from('pending'))->toBe(CheckoutStatus::Pending);
    expect(CheckoutStatus::from('processing'))->toBe(CheckoutStatus::Processing);
    expect(CheckoutStatus::from('completed'))->toBe(CheckoutStatus::Completed);
    expect(CheckoutStatus::from('expired'))->toBe(CheckoutStatus::Expired);
});
