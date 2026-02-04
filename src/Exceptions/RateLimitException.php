<?php

namespace Creem\Exceptions;

class RateLimitException extends CreemException
{
    public function __construct(
        string $message = 'Rate limit exceeded',
        mixed $body = null,
        array $headers = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 429, $body, $headers, null, $previous);
    }
}
