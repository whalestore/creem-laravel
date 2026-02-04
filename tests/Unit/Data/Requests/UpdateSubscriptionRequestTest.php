<?php

use Creem\Data\Requests\UpdateSubscriptionRequest;

test('update subscription request with default values', function () {
    $request = new UpdateSubscriptionRequest();

    expect($request->items)->toBeNull();
    expect($request->metadata)->toBeNull();
});

test('update subscription request with items', function () {
    $request = new UpdateSubscriptionRequest(
        items: [
            ['product' => 'prod_123', 'quantity' => 2],
        ],
    );

    expect($request->items)->toHaveCount(1);
    expect($request->items[0]['quantity'])->toBe(2);
});

test('update subscription request with metadata', function () {
    $request = new UpdateSubscriptionRequest(
        metadata: 'custom_data',
    );

    expect($request->metadata)->toBe('custom_data');
});
