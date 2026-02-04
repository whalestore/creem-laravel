<?php

use Creem\Data\Enums\TransactionType;

test('transaction type has all expected values', function () {
    expect(TransactionType::cases())->toHaveCount(2);
    expect(TransactionType::Payment->value)->toBe('payment');
    expect(TransactionType::Invoice->value)->toBe('invoice');
});

test('transaction type can be created from string', function () {
    expect(TransactionType::from('payment'))->toBe(TransactionType::Payment);
    expect(TransactionType::from('invoice'))->toBe(TransactionType::Invoice);
});
