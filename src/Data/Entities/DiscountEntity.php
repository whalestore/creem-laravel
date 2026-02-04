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
use Creem\Data\Enums\DiscountStatus;
use Creem\Data\Enums\DiscountType;
use Creem\Data\Enums\CouponDurationType;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class DiscountEntity extends Data
{
    public function __construct(
        public string $id,
        public EnvironmentMode $mode,
        public string $object,
        public DiscountStatus $status,
        public string $name,
        public string $code,
        public DiscountType $type,
        public ?int $amount = null,
        public ?string $currency = null,
        public ?float $percentage = null,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s\Z')]
        public ?DateTime $expiryDate = null,
        public ?int $maxRedemptions = null,
        public ?CouponDurationType $duration = null,
        public ?int $durationInMonths = null,
        public ?array $appliesToProducts = null,
        public ?int $redeemCount = null,
    ) {}
}
