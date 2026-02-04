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
use Creem\Data\Enums\LicenseStatus;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class LicenseInstanceEntity extends Data
{
    public function __construct(
        public string $id,
        public EnvironmentMode $mode,
        public string $object,
        public string $name,
        public string $status,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s\Z')]
        public DateTime $createdAt,
    ) {}
}
