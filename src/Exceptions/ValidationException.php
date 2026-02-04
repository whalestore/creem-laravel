<?php

namespace Creem\Exceptions;

class ValidationException extends CreemException
{
    public function __construct(
        string $message = 'Validation failed',
        mixed $body = null,
        array $headers = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 400, $body, $headers, null, $previous);
    }
}
