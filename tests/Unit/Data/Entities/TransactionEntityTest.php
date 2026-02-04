<?php

use Creem\Data\Entities\TransactionEntity;
use Creem\Data\Enums\EnvironmentMode;
use Creem\Data\Enums\TransactionStatus;
use Creem\Data\Enums\TransactionType;

test('transaction entity can be created from array', function () {
    $data = [
        'id' => 'txn_123',
        'mode' => 'test',
        'object' => 'transaction',
        'amount' => 5000,
        'currency' => 'USD',
        'type' => 'payment',
        'status' => 'paid',
        'created_at' => 1704067200,
        'customer' => 'cust_123',
    ];

    $transaction = TransactionEntity::from($data);

    expect($transaction->id)->toBe('txn_123');
    expect($transaction->mode)->toBe(EnvironmentMode::Test);
    expect($transaction->amount)->toBe(5000);
    expect($transaction->type)->toBe(TransactionType::Payment);
    expect($transaction->status)->toBe(TransactionStatus::Paid);
    expect($transaction->customer)->toBe('cust_123');
});

test('transaction entity handles optional fields', function () {
    $data = [
        'id' => 'txn_123',
        'mode' => 'prod',
        'object' => 'transaction',
        'amount' => 1000,
        'currency' => 'EUR',
        'type' => 'invoice',
        'status' => 'pending',
        'created_at' => 1704067200,
    ];

    $transaction = TransactionEntity::from($data);

    expect($transaction->customer)->toBeNull();
    expect($transaction->refundedAmount)->toBeNull();
    expect($transaction->taxAmount)->toBeNull();
});

test('transaction entity serializes to array', function () {
    $transaction = new TransactionEntity(
        id: 'txn_123',
        mode: EnvironmentMode::Test,
        object: 'transaction',
        amount: 5000,
        currency: 'USD',
        type: TransactionType::Payment,
        status: TransactionStatus::Paid,
        createdAt: 1704067200,
    );

    $array = $transaction->toArray();

    expect($array['type'])->toBe('payment');
    expect($array['status'])->toBe('paid');
});
