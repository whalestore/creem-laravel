<?php

namespace Creem\Data\Requests;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Creem\Data\Enums\ProductCurrency;
use Creem\Data\Enums\ProductBillingType;
use Creem\Data\Enums\ProductBillingPeriod;
use Creem\Data\Enums\TaxMode;
use Creem\Data\Enums\TaxCategory;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CreateProductRequest extends Data
{
    public function __construct(
        public string $name,
        public int $price,
        public ProductCurrency $currency,
        public ProductBillingType $billingType,
        public string $description = '',
        public ?string $imageUrl = null,
        public ?ProductBillingPeriod $billingPeriod = null,
        public ?TaxMode $taxMode = null,
        public ?TaxCategory $taxCategory = null,
        public ?string $defaultSuccessUrl = null,
        public ?array $customFields = null,
        public ?bool $abandonedCartRecoveryEnabled = null,
    ) {}
}
