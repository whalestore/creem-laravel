<?php

namespace Creem\Data\Entities;

use DateTime;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Creem\Data\Enums\EnvironmentMode;
use Creem\Data\Enums\SubscriptionStatus;
use Creem\Data\Enums\SubscriptionCollectionMethod;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SubscriptionEntity extends Data
{
    public function __construct(
        public string $id,
        public EnvironmentMode $mode,
        public string $object,
        public SubscriptionStatus $status,
        public ?ProductEntity $product = null,
        public ?CustomerEntity $customer = null,
        public ?int $quantity = null,
        public ?SubscriptionCollectionMethod $collectionMethod = null,
        public ?int $currentPeriodStart = null,
        public ?int $currentPeriodEnd = null,
        public ?int $cancelAtPeriodEnd = null,
        public ?int $canceledAt = null,
        public ?int $pausedAt = null,
        public ?int $resumeAt = null,
        public ?int $trialStart = null,
        public ?int $trialEnd = null,
        public ?string $metadata = null,
        public ?int $createdAt = null,
        public ?int $updatedAt = null,
        #[DataCollectionOf(SubscriptionItemEntity::class)]
        public ?array $items = null,
    ) {}
}
