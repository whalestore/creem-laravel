<?php

use Creem\Webhooks\WebhookHandler;
use Creem\Webhooks\Events\CreemWebhookReceived;
use Creem\Webhooks\Events\CheckoutCompleted;
use Creem\Webhooks\Events\SubscriptionActive;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    Event::fake();
});

test('webhook handler dispatches generic event', function () {
    $handler = new WebhookHandler();
    $payload = [
        'event_type' => 'checkout.completed',
        'object' => 'event',
        'data' => ['id' => 'ch_123'],
    ];
    $rawContent = json_encode($payload);
    $secret = 'test_secret';
    $signature = hash_hmac('sha256', $rawContent, $secret);

    $handler->handle($payload, $rawContent, $signature, $secret);

    Event::assertDispatched(CreemWebhookReceived::class);
});

test('webhook handler dispatches checkout completed event', function () {
    $handler = new WebhookHandler();
    $payload = [
        'event_type' => 'checkout.completed',
        'object' => 'event',
        'data' => ['id' => 'ch_123'],
    ];
    $rawContent = json_encode($payload);
    $secret = 'test_secret';
    $signature = hash_hmac('sha256', $rawContent, $secret);

    $handler->handle($payload, $rawContent, $signature, $secret);

    Event::assertDispatched(CheckoutCompleted::class);
});

test('webhook handler dispatches subscription active event', function () {
    $handler = new WebhookHandler();
    $payload = [
        'event_type' => 'subscription.active',
        'object' => 'event',
        'data' => ['id' => 'sub_123'],
    ];
    $rawContent = json_encode($payload);
    $secret = 'test_secret';
    $signature = hash_hmac('sha256', $rawContent, $secret);

    $handler->handle($payload, $rawContent, $signature, $secret);

    Event::assertDispatched(SubscriptionActive::class);
});

test('webhook handler throws on invalid signature', function () {
    $handler = new WebhookHandler();
    $payload = [
        'event_type' => 'test.event',
        'object' => 'event',
        'data' => [],
    ];
    $rawContent = json_encode($payload);
    $secret = 'test_secret';
    $invalidSignature = 'invalid';

    expect(fn() => $handler->handle($payload, $rawContent, $invalidSignature, $secret))
        ->toThrow(\Creem\Exceptions\ValidationException::class);
});
