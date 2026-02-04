<?php

use Creem\Resources\Discounts;
use Creem\Data\Entities\DiscountEntity;
use Creem\Data\Requests\CreateDiscountRequest;
use Creem\Data\Enums\DiscountType;
use Creem\Http\HttpClient;
use Mockery;

test('discounts resource can get discount by id', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/discounts', ['discount_id' => 'disc_123'])
        ->once()
        ->andReturn([
            'id' => 'disc_123',
            'mode' => 'test',
            'object' => 'discount',
            'status' => 'active',
            'name' => 'Summer Sale',
            'code' => 'SUMMER20',
            'type' => 'percentage',
            'percentage' => 20.0,
        ]);

    $discounts = new Discounts($httpClient);
    $discount = $discounts->get(discountId: 'disc_123');

    expect($discount)->toBeInstanceOf(DiscountEntity::class);
    expect($discount->name)->toBe('Summer Sale');
    expect($discount->code)->toBe('SUMMER20');
});

test('discounts resource can get discount by code', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/discounts', ['discount_code' => 'SUMMER20'])
        ->once()
        ->andReturn([
            'id' => 'disc_123',
            'mode' => 'test',
            'object' => 'discount',
            'status' => 'active',
            'name' => 'Summer Sale',
            'code' => 'SUMMER20',
            'type' => 'percentage',
            'percentage' => 20.0,
        ]);

    $discounts = new Discounts($httpClient);
    $discount = $discounts->get(discountCode: 'SUMMER20');

    expect($discount)->toBeInstanceOf(DiscountEntity::class);
    expect($discount->code)->toBe('SUMMER20');
});

test('discounts resource can create discount', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/discounts', Mockery::any())
        ->once()
        ->andReturn([
            'id' => 'disc_new',
            'mode' => 'test',
            'object' => 'discount',
            'status' => 'draft',
            'name' => 'New Discount',
            'code' => 'NEWCODE',
            'type' => 'fixed',
            'amount' => 500,
            'currency' => 'USD',
        ]);

    $discounts = new Discounts($httpClient);
    $request = new CreateDiscountRequest(
        name: 'New Discount',
        code: 'NEWCODE',
        type: DiscountType::Fixed,
        amount: 500,
        currency: 'USD',
    );
    $discount = $discounts->create($request);

    expect($discount)->toBeInstanceOf(DiscountEntity::class);
    expect($discount->amount)->toBe(500);
});

test('discounts resource can delete discount', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('delete')
        ->with('/v1/discounts', ['id' => 'disc_123'])
        ->once()
        ->andReturn([
            'id' => 'disc_123',
            'mode' => 'test',
            'object' => 'discount',
            'status' => 'expired',
            'name' => 'Deleted',
            'code' => 'DELETED',
            'type' => 'percentage',
            'percentage' => 10.0,
        ]);

    $discounts = new Discounts($httpClient);
    $discount = $discounts->delete('disc_123');

    expect($discount)->toBeInstanceOf(DiscountEntity::class);
});

afterEach(function () {
    Mockery::close();
});
