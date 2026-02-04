<?php

namespace Creem\Data\Entities;

use DateTime;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Creem\Data\Enums\EnvironmentMode;
use Creem\Data\Enums\TransactionStatus;
use Creem\Data\Enums\TransactionType;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class TransactionEntity extends Data
{
    public function __construct(
        public string $id,
        public EnvironmentMode $mode,
        public string $object,
        public int $amount,
        public string $currency,
        public TransactionType $type,
        public TransactionStatus $status,
        public int $createdAt,
        public ?int $amountPaid = null,
        public ?int $discountAmount = null,
        public ?string $taxCountry = null,
        public ?int $taxAmount = null,
        public ?int $refundedAmount = null,
        public ?string $order = null,
        public ?string $subscription = null,
        public ?string $customer = null,
        public ?string $description = null,
        public ?int $periodStart = null,
        public ?int $periodEnd = null,
    ) {}
}
