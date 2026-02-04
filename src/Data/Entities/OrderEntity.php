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
use Creem\Data\Enums\OrderStatus;
use Creem\Data\Enums\OrderType;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class OrderEntity extends Data
{
    public function __construct(
        public string $id,
        public EnvironmentMode $mode,
        public string $object,
        public string $product,
        public int $amount,
        public string $currency,
        public OrderStatus $status,
        public OrderType $type,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s\Z')]
        public DateTime $createdAt,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s\Z')]
        public DateTime $updatedAt,
        public ?string $customer = null,
        public ?string $transaction = null,
        public ?string $discount = null,
        public ?int $subTotal = null,
        public ?int $taxAmount = null,
        public ?int $discountAmount = null,
        public ?int $amountDue = null,
        public ?int $amountPaid = null,
        public ?int $fxAmount = null,
        public ?string $fxCurrency = null,
        public ?float $fxRate = null,
        public ?string $affiliate = null,
    ) {}
}
