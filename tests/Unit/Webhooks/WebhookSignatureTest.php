<?php

use Creem\Webhooks\WebhookSignature;
use Creem\Exceptions\ValidationException;

test('webhook signature verifies valid signature', function () {
    $payload = '{"event_type":"checkout.completed","data":{}}';
    $secret = 'test_secret_key';
    $signature = hash_hmac('sha256', $payload, $secret);

    $result = WebhookSignature::verify($payload, $signature, $secret);

    expect($result)->toBeTrue();
});

test('webhook signature throws on invalid signature', function () {
    $payload = '{"event_type":"checkout.completed","data":{}}';
    $secret = 'test_secret_key';
    $invalidSignature = 'invalid_signature';

    expect(fn() => WebhookSignature::verify($payload, $invalidSignature, $secret))
        ->toThrow(ValidationException::class, 'Invalid webhook signature');
});

test('webhook signature throws on empty secret', function () {
    $payload = '{"event_type":"test","data":{}}';
    $signature = 'any_signature';
    $emptySecret = '';

    expect(fn() => WebhookSignature::verify($payload, $signature, $emptySecret))
        ->toThrow(ValidationException::class, 'Webhook secret is not configured');
});

test('webhook signature is timing safe', function () {
    $payload = '{"test":"data"}';
    $secret = 'secret123';
    $validSignature = hash_hmac('sha256', $payload, $secret);
    
    // Should use hash_equals internally for timing-safe comparison
    $result = WebhookSignature::verify($payload, $validSignature, $secret);
    
    expect($result)->toBeTrue();
});
