<?php

use Creem\Resources\Products;
use Creem\Data\Entities\ProductEntity;
use Creem\Data\Requests\CreateProductRequest;
use Creem\Data\Enums\ProductCurrency;
use Creem\Data\Enums\ProductBillingType;
use Creem\Http\HttpClient;
use Mockery;

test('products resource can get product by id', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/products', ['product_id' => 'prod_123'])
        ->once()
        ->andReturn([
            'id' => 'prod_123',
            'mode' => 'test',
            'object' => 'product',
            'name' => 'Test Product',
            'price' => 1000,
            'currency' => 'USD',
            'billing_type' => 'recurring',
            'status' => 'active',
            'created_at' => '2024-01-01T00:00:00Z',
            'updated_at' => '2024-01-02T00:00:00Z',
        ]);

    $products = new Products($httpClient);
    $product = $products->get('prod_123');

    expect($product)->toBeInstanceOf(ProductEntity::class);
    expect($product->id)->toBe('prod_123');
    expect($product->name)->toBe('Test Product');
});

test('products resource can search products', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/products/search', ['page_number' => 1, 'page_size' => 10])
        ->once()
        ->andReturn([
            'items' => [
                [
                    'id' => 'prod_1',
                    'mode' => 'test',
                    'object' => 'product',
                    'name' => 'Product 1',
                    'price' => 1000,
                    'currency' => 'USD',
                    'billing_type' => 'recurring',
                    'status' => 'active',
                    'created_at' => '2024-01-01T00:00:00Z',
                    'updated_at' => '2024-01-02T00:00:00Z',
                ],
            ],
            'pagination' => [
                'total_records' => 1,
                'total_pages' => 1,
                'current_page' => 1,
            ],
        ]);

    $products = new Products($httpClient);
    $result = $products->search(1, 10);

    expect($result['items'])->toHaveCount(1);
    expect($result['items'][0])->toBeInstanceOf(ProductEntity::class);
});

test('products resource can create product', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/products', Mockery::any())
        ->once()
        ->andReturn([
            'id' => 'prod_new',
            'mode' => 'test',
            'object' => 'product',
            'name' => 'New Product',
            'price' => 2000,
            'currency' => 'USD',
            'billing_type' => 'onetime',
            'status' => 'active',
            'created_at' => '2024-01-01T00:00:00Z',
            'updated_at' => '2024-01-02T00:00:00Z',
        ]);

    $products = new Products($httpClient);
    $request = new CreateProductRequest(
        name: 'New Product',
        price: 2000,
        currency: ProductCurrency::USD,
        billingType: ProductBillingType::Onetime,
    );

    $product = $products->create($request);

    expect($product)->toBeInstanceOf(ProductEntity::class);
    expect($product->name)->toBe('New Product');
});

afterEach(function () {
    Mockery::close();
});
