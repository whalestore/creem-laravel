<?php

namespace Creem\Data\Requests;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Creem\Data\Enums\DiscountType;
use Creem\Data\Enums\CouponDurationType;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CreateDiscountRequest extends Data
{
    public function __construct(
        public string $name,
        public string $code,
        public DiscountType $type,
        public ?int $amount = null,
        public ?string $currency = null,
        public ?float $percentage = null,
        public ?string $expiryDate = null,
        public ?int $maxRedemptions = null,
        public ?CouponDurationType $duration = null,
        public ?int $durationInMonths = null,
        public ?array $appliesToProducts = null,
    ) {}
}
