<?php

namespace Creem\Webhooks;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class WebhookEvent extends Data
{
    public function __construct(
        public string $eventType,
        public string $object,
        public array $data,
        public ?string $id = null,
        public ?int $createdAt = null,
    ) {}

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
