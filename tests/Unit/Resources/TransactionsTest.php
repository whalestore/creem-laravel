<?php

use Creem\Resources\Transactions;
use Creem\Data\Entities\TransactionEntity;
use Creem\Http\HttpClient;
use Mockery;

test('transactions resource can get transaction by id', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/transactions', ['id' => 'txn_123'])
        ->once()
        ->andReturn([
            'id' => 'txn_123',
            'mode' => 'test',
            'object' => 'transaction',
            'amount' => 5000,
            'currency' => 'USD',
            'type' => 'payment',
            'status' => 'paid',
            'created_at' => 1704067200,
        ]);

    $transactions = new Transactions($httpClient);
    $transaction = $transactions->getById('txn_123');

    expect($transaction)->toBeInstanceOf(TransactionEntity::class);
    expect($transaction->id)->toBe('txn_123');
    expect($transaction->amount)->toBe(5000);
});

test('transactions resource can search transactions', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/transactions/search', ['page_number' => 1, 'page_size' => 25])
        ->once()
        ->andReturn([
            'items' => [
                [
                    'id' => 'txn_1',
                    'mode' => 'test',
                    'object' => 'transaction',
                    'amount' => 1000,
                    'currency' => 'EUR',
                    'type' => 'invoice',
                    'status' => 'pending',
                    'created_at' => 1704067200,
                ],
            ],
            'pagination' => [
                'total_records' => 1,
                'total_pages' => 1,
                'current_page' => 1,
            ],
        ]);

    $transactions = new Transactions($httpClient);
    $result = $transactions->search(pageNumber: 1, pageSize: 25);

    expect($result['items'])->toHaveCount(1);
    expect($result['items'][0])->toBeInstanceOf(TransactionEntity::class);
});

test('transactions resource can search with filters', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('get')
        ->with('/v1/transactions/search', Mockery::on(function ($params) {
            return isset($params['customer_id']) && $params['customer_id'] === 'cust_123';
        }))
        ->once()
        ->andReturn([
            'items' => [],
            'pagination' => null,
        ]);

    $transactions = new Transactions($httpClient);
    $result = $transactions->search(customerId: 'cust_123');

    expect($result['items'])->toHaveCount(0);
});

afterEach(function () {
    Mockery::close();
});
