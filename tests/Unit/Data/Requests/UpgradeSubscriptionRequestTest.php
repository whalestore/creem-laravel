<?php

use Creem\Data\Requests\UpgradeSubscriptionRequest;

test('upgrade subscription request with new product id', function () {
    $request = new UpgradeSubscriptionRequest(
        newProductId: 'prod_456',
    );

    expect($request->newProductId)->toBe('prod_456');
});

test('upgrade subscription request serializes to array', function () {
    $request = new UpgradeSubscriptionRequest(
        newProductId: 'prod_789',
    );

    $array = $request->toArray();

    expect($array)->toHaveKey('new_product_id');
    expect($array['new_product_id'])->toBe('prod_789');
});
