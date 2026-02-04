<?php

namespace Creem\Data\Requests;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateSubscriptionRequest extends Data
{
    public function __construct(
        public ?array $items = null,
        public ?string $metadata = null,
    ) {}
}
