<?php

use Creem\Data\Requests\CancelSubscriptionRequest;

test('cancel subscription request with default values', function () {
    $request = new CancelSubscriptionRequest();

    expect($request->cancelAtPeriodEnd)->toBeNull();
});

test('cancel subscription request with cancel at period end', function () {
    $request = new CancelSubscriptionRequest(
        cancelAtPeriodEnd: true,
    );

    expect($request->cancelAtPeriodEnd)->toBeTrue();
});

test('cancel subscription request with immediate cancel', function () {
    $request = new CancelSubscriptionRequest(
        cancelAtPeriodEnd: false,
    );

    expect($request->cancelAtPeriodEnd)->toBeFalse();
});

test('cancel subscription request serializes to array', function () {
    $request = new CancelSubscriptionRequest(
        cancelAtPeriodEnd: true,
    );

    $array = $request->toArray();

    expect($array)->toHaveKey('cancel_at_period_end');
    expect($array['cancel_at_period_end'])->toBeTrue();
});
