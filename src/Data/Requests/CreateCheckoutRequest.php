<?php

namespace Creem\Data\Requests;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CreateCheckoutRequest extends Data
{
    public function __construct(
        public string $productId,
        public string $successUrl,
        public ?int $units = null,
        public ?CustomerRequest $customer = null,
        public ?string $discountCode = null,
        public ?string $requestId = null,
        public ?array $metadata = null,
    ) {}
}
