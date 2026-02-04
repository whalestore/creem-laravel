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
use Creem\Data\Enums\ProductBillingType;
use Creem\Data\Enums\ProductBillingPeriod;
use Creem\Data\Enums\ProductStatus;
use Creem\Data\Enums\TaxMode;
use Creem\Data\Enums\TaxCategory;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ProductEntity extends Data
{
    public function __construct(
        public string $id,
        public EnvironmentMode $mode,
        public string $object,
        public string $name,
        public int $price,
        public string $currency,
        public ProductBillingType $billingType,
        public ProductStatus $status,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s\Z')]
        public DateTime $createdAt,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s\Z')]
        public DateTime $updatedAt,
        public ?string $description = null,
        public ?string $imageUrl = null,
        public ?ProductBillingPeriod $billingPeriod = null,
        public ?TaxMode $taxMode = null,
        public ?TaxCategory $taxCategory = null,
        public ?string $defaultSuccessUrl = null,
        public ?bool $abandonedCartRecoveryEnabled = null,
        public ?array $customFields = null,
        public ?array $features = null,
    ) {}
}
