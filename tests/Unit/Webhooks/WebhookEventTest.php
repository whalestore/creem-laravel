<?php

use Creem\Webhooks\WebhookEvent;

test('webhook event can be created from array', function () {
    $data = [
        'event_type' => 'checkout.completed',
        'object' => 'event',
        'data' => [
            'id' => 'ch_123',
            'status' => 'completed',
        ],
        'id' => 'evt_123',
        'created_at' => 1704067200,
    ];

    $event = WebhookEvent::from($data);

    expect($event->eventType)->toBe('checkout.completed');
    expect($event->object)->toBe('event');
    expect($event->data)->toBe(['id' => 'ch_123', 'status' => 'completed']);
    expect($event->id)->toBe('evt_123');
    expect($event->createdAt)->toBe(1704067200);
});

test('webhook event get event type method', function () {
    $event = new WebhookEvent(
        eventType: 'subscription.active',
        object: 'event',
        data: ['id' => 'sub_123'],
    );

    expect($event->getEventType())->toBe('subscription.active');
});

test('webhook event get data method', function () {
    $eventData = ['id' => 'sub_456', 'status' => 'active'];
    $event = new WebhookEvent(
        eventType: 'subscription.active',
        object: 'event',
        data: $eventData,
    );

    expect($event->getData())->toBe($eventData);
});

test('webhook event handles optional fields', function () {
    $event = new WebhookEvent(
        eventType: 'test.event',
        object: 'event',
        data: [],
    );

    expect($event->id)->toBeNull();
    expect($event->createdAt)->toBeNull();
});
