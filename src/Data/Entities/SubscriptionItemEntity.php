<?php

namespace Creem\Data\Entities;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Creem\Data\Enums\EnvironmentMode;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SubscriptionItemEntity extends Data
{
    public function __construct(
        public string $id,
        public EnvironmentMode $mode,
        public string $object,
        public string $product,
        public int $quantity,
        public int $createdAt,
    ) {}
}
