<?php

use Creem\Data\Enums\SubscriptionCollectionMethod;

test('subscription collection method has all expected values', function () {
    expect(SubscriptionCollectionMethod::cases())->toHaveCount(2);
    expect(SubscriptionCollectionMethod::ChargeAutomatically->value)->toBe('charge_automatically');
    expect(SubscriptionCollectionMethod::SendInvoice->value)->toBe('send_invoice');
});

test('subscription collection method can be created from string', function () {
    expect(SubscriptionCollectionMethod::from('charge_automatically'))->toBe(SubscriptionCollectionMethod::ChargeAutomatically);
    expect(SubscriptionCollectionMethod::from('send_invoice'))->toBe(SubscriptionCollectionMethod::SendInvoice);
});
