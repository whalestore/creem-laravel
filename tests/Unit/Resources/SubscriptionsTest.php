<?php

use Creem\Resources\Subscriptions;
use Creem\Data\Entities\SubscriptionEntity;
use Creem\Data\Requests\CancelSubscriptionRequest;
use Creem\Data\Requests\UpgradeSubscriptionRequest;
use Creem\Http\HttpClient;
use Mockery;

test('subscriptions resource can get subscription by id', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/subscriptions', ['subscription_id' => 'sub_123'])
        ->once()
        ->andReturn([
            'id' => 'sub_123',
            'mode' => 'test',
            'object' => 'subscription',
            'status' => 'active',
            'quantity' => 1,
        ]);

    $subscriptions = new Subscriptions($httpClient);
    $subscription = $subscriptions->get('sub_123');

    expect($subscription)->toBeInstanceOf(SubscriptionEntity::class);
    expect($subscription->id)->toBe('sub_123');
});

test('subscriptions resource can cancel subscription', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/subscriptions/cancel', Mockery::on(function ($data) {
            return $data['id'] === 'sub_123' && isset($data['cancel_at_period_end']);
        }))
        ->once()
        ->andReturn([
            'id' => 'sub_123',
            'mode' => 'test',
            'object' => 'subscription',
            'status' => 'canceled',
        ]);

    $subscriptions = new Subscriptions($httpClient);
    $request = new CancelSubscriptionRequest(cancelAtPeriodEnd: true);
    $subscription = $subscriptions->cancel('sub_123', $request);

    expect($subscription)->toBeInstanceOf(SubscriptionEntity::class);
    expect($subscription->status->value)->toBe('canceled');
});

test('subscriptions resource can upgrade subscription', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/subscriptions/upgrade', Mockery::on(function ($data) {
            return $data['id'] === 'sub_123' && isset($data['new_product_id']);
        }))
        ->once()
        ->andReturn([
            'id' => 'sub_123',
            'mode' => 'test',
            'object' => 'subscription',
            'status' => 'active',
        ]);

    $subscriptions = new Subscriptions($httpClient);
    $request = new UpgradeSubscriptionRequest(newProductId: 'prod_456');
    $subscription = $subscriptions->upgrade('sub_123', $request);

    expect($subscription)->toBeInstanceOf(SubscriptionEntity::class);
});

test('subscriptions resource can pause subscription', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/subscriptions/pause', ['id' => 'sub_123'])
        ->once()
        ->andReturn([
            'id' => 'sub_123',
            'mode' => 'test',
            'object' => 'subscription',
            'status' => 'paused',
        ]);

    $subscriptions = new Subscriptions($httpClient);
    $subscription = $subscriptions->pause('sub_123');

    expect($subscription)->toBeInstanceOf(SubscriptionEntity::class);
    expect($subscription->status->value)->toBe('paused');
});

test('subscriptions resource can resume subscription', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/subscriptions/resume', ['id' => 'sub_123'])
        ->once()
        ->andReturn([
            'id' => 'sub_123',
            'mode' => 'test',
            'object' => 'subscription',
            'status' => 'active',
        ]);

    $subscriptions = new Subscriptions($httpClient);
    $subscription = $subscriptions->resume('sub_123');

    expect($subscription)->toBeInstanceOf(SubscriptionEntity::class);
    expect($subscription->status->value)->toBe('active');
});

afterEach(function () {
    Mockery::close();
});
