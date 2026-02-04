<?php

namespace Creem\Exceptions;

class ConnectionException extends CreemException
{
    public function __construct(
        string $message = 'Connection failed',
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, null, null, [], null, $previous);
    }
}
