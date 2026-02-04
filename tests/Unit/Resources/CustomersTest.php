<?php

use Creem\Resources\Customers;
use Creem\Data\Entities\CustomerEntity;
use Creem\Data\Requests\CreateCustomerPortalLinkRequest;
use Creem\Http\HttpClient;
use Mockery;

test('customers resource can retrieve customer by id', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/customers/retrieve', ['customer_id' => 'cust_123'])
        ->once()
        ->andReturn([
            'id' => 'cust_123',
            'mode' => 'test',
            'object' => 'customer',
            'email' => 'test@example.com',
            'name' => 'Test Customer',
            'country' => 'US',
            'created_at' => '2024-01-01T00:00:00Z',
            'updated_at' => '2024-01-02T00:00:00Z',
        ]);

    $customers = new Customers($httpClient);
    $customer = $customers->retrieve(customerId: 'cust_123');

    expect($customer)->toBeInstanceOf(CustomerEntity::class);
    expect($customer->id)->toBe('cust_123');
    expect($customer->email)->toBe('test@example.com');
});

test('customers resource can retrieve customer by email', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/customers/retrieve', ['email' => 'test@example.com'])
        ->once()
        ->andReturn([
            'id' => 'cust_456',
            'mode' => 'test',
            'object' => 'customer',
            'email' => 'test@example.com',
            'country' => 'DE',
            'created_at' => '2024-01-01T00:00:00Z',
            'updated_at' => '2024-01-02T00:00:00Z',
        ]);

    $customers = new Customers($httpClient);
    $customer = $customers->retrieve(email: 'test@example.com');

    expect($customer)->toBeInstanceOf(CustomerEntity::class);
    expect($customer->email)->toBe('test@example.com');
});

test('customers resource can list customers', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/customers', ['page_number' => 1, 'page_size' => 20])
        ->once()
        ->andReturn([
            'items' => [
                [
                    'id' => 'cust_1',
                    'mode' => 'test',
                    'object' => 'customer',
                    'email' => 'user1@example.com',
                    'country' => 'DE',
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

    $customers = new Customers($httpClient);
    $result = $customers->list(1, 20);

    expect($result['items'])->toHaveCount(1);
    expect($result['items'][0])->toBeInstanceOf(CustomerEntity::class);
});

test('customers resource can generate billing portal link', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/customers/billing-portal', Mockery::any())
        ->once()
        ->andReturn([
            'customer_portal_url' => 'https://billing.creem.io/portal/xxx',
        ]);

    $customers = new Customers($httpClient);
    $request = new CreateCustomerPortalLinkRequest(
        customerId: 'cust_123',
        returnUrl: 'https://example.com/return',
    );
    $result = $customers->generateBillingLinks($request);

    expect($result['customer_portal_url'])->toBe('https://billing.creem.io/portal/xxx');
});

afterEach(function () {
    Mockery::close();
});
