<?php

namespace Creem\Exceptions;

class NotFoundException extends CreemException
{
    public function __construct(
        string $message = 'Resource not found',
        mixed $body = null,
        array $headers = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 404, $body, $headers, null, $previous);
    }
}
