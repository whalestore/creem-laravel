<?php

use Creem\Data\Enums\TransactionStatus;

test('transaction status has all expected values', function () {
    expect(TransactionStatus::cases())->toHaveCount(8);
    expect(TransactionStatus::Pending->value)->toBe('pending');
    expect(TransactionStatus::Paid->value)->toBe('paid');
    expect(TransactionStatus::Refunded->value)->toBe('refunded');
    expect(TransactionStatus::PartialRefund->value)->toBe('partialRefund');
    expect(TransactionStatus::ChargedBack->value)->toBe('chargedBack');
    expect(TransactionStatus::Uncollectible->value)->toBe('uncollectible');
    expect(TransactionStatus::Declined->value)->toBe('declined');
    expect(TransactionStatus::Void->value)->toBe('void');
});

test('transaction status can be created from string', function () {
    expect(TransactionStatus::from('pending'))->toBe(TransactionStatus::Pending);
    expect(TransactionStatus::from('paid'))->toBe(TransactionStatus::Paid);
    expect(TransactionStatus::from('partialRefund'))->toBe(TransactionStatus::PartialRefund);
});
