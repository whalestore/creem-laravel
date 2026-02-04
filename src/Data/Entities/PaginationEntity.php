<?php

namespace Creem\Data\Entities;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class PaginationEntity extends Data
{
    public function __construct(
        public int $totalRecords,
        public int $totalPages,
        public int $currentPage,
        public ?int $nextPage = null,
        public ?int $prevPage = null,
    ) {}
}
