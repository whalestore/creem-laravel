<?php

namespace Creem\Exceptions;

class AuthenticationException extends CreemException
{
    public function __construct(
        string $message = 'Authentication failed',
        mixed $body = null,
        array $headers = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 401, $body, $headers, null, $previous);
    }
}
