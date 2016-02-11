<?php

namespace PhpDatabaseApplication\Exception\Api;

use Exception;

class MethodNotAllowed extends Exception implements ApiExceptionInterface
{
    public function __construct($message = 'This HTTP method is not allowed.', $code = 405, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
