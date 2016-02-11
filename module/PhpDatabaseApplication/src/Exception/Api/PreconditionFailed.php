<?php

namespace PhpDatabaseApplication\Exception\Api;

use Exception;

class PreconditionFailed extends Exception implements ApiExceptionInterface
{
    public function __construct($message, $code = 412, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
