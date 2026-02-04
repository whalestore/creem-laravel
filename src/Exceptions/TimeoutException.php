<?php

namespace Creem\Exceptions;

class TimeoutException extends CreemException
{
    public function __construct(
        string $message = 'Request timed out',
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, null, null, [], null, $previous);
    }
}
