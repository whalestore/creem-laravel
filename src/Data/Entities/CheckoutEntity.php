<?php

namespace Creem\Data\Entities;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Creem\Data\Enums\EnvironmentMode;
use Creem\Data\Enums\CheckoutStatus;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CheckoutEntity extends Data
{
    public function __construct(
        public string $id,
        public EnvironmentMode $mode,
        public string $object,
        public CheckoutStatus $status,
        public string $checkoutUrl,
        public ?ProductEntity $product = null,
        public ?CustomerEntity $customer = null,
        public ?OrderEntity $order = null,
        public ?SubscriptionEntity $subscription = null,
        public ?string $requestId = null,
        public ?string $successUrl = null,
        public ?int $expiresAt = null,
        public ?int $createdAt = null,
        public ?int $updatedAt = null,
        public ?array $customFields = null,
        public ?array $metadata = null,
    ) {}
}
