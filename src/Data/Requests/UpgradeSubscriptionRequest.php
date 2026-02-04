<?php

namespace Creem\Data\Requests;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UpgradeSubscriptionRequest extends Data
{
    public function __construct(
        public string $newProductId,
    ) {}
}
