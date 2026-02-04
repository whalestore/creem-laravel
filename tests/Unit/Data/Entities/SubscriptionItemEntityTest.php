<?php

use Creem\Data\Entities\SubscriptionItemEntity;
use Creem\Data\Enums\EnvironmentMode;

test('subscription item entity can be created from array', function () {
    $data = [
        'id' => 'si_123',
        'mode' => 'test',
        'object' => 'subscription_item',
        'product' => 'prod_123',
        'quantity' => 2,
        'created_at' => 1704067200,
    ];

    $item = SubscriptionItemEntity::from($data);

    expect($item->id)->toBe('si_123');
    expect($item->mode)->toBe(EnvironmentMode::Test);
    expect($item->product)->toBe('prod_123');
    expect($item->quantity)->toBe(2);
    expect($item->createdAt)->toBe(1704067200);
});

test('subscription item entity serializes to array', function () {
    $item = new SubscriptionItemEntity(
        id: 'si_123',
        mode: EnvironmentMode::Test,
        object: 'subscription_item',
        product: 'prod_123',
        quantity: 1,
        createdAt: 1704067200,
    );

    $array = $item->toArray();

    expect($array['mode'])->toBe('test');
    expect($array['created_at'])->toBe(1704067200);
});
