<?php

use Creem\Resources\Checkouts;
use Creem\Data\Entities\CheckoutEntity;
use Creem\Data\Requests\CreateCheckoutRequest;
use Creem\Http\HttpClient;
use Mockery;

test('checkouts resource can retrieve checkout by id', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/checkouts', ['checkout_id' => 'ch_123'])
        ->once()
        ->andReturn([
            'id' => 'ch_123',
            'mode' => 'test',
            'object' => 'checkout',
            'status' => 'pending',
            'checkout_url' => 'https://checkout.creem.io/ch_123',
        ]);

    $checkouts = new Checkouts($httpClient);
    $checkout = $checkouts->retrieve('ch_123');

    expect($checkout)->toBeInstanceOf(CheckoutEntity::class);
    expect($checkout->id)->toBe('ch_123');
    expect($checkout->checkoutUrl)->toBe('https://checkout.creem.io/ch_123');
});

test('checkouts resource can create checkout', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/checkouts', Mockery::any())
        ->once()
        ->andReturn([
            'id' => 'ch_new',
            'mode' => 'test',
            'object' => 'checkout',
            'status' => 'pending',
            'checkout_url' => 'https://checkout.creem.io/ch_new',
        ]);

    $checkouts = new Checkouts($httpClient);
    $request = new CreateCheckoutRequest(
        productId: 'prod_123',
        successUrl: 'https://example.com/success',
    );
    $checkout = $checkouts->create($request);

    expect($checkout)->toBeInstanceOf(CheckoutEntity::class);
    expect($checkout->id)->toBe('ch_new');
});

afterEach(function () {
    Mockery::close();
});
