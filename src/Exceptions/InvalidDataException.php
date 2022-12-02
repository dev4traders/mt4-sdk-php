<?php

namespace D4T\MT4Sdk\Exceptions;

use Exception;

class InvalidDataException extends Exception
{
    public function __construct(string $error)
    {
        parent::__construct($error);
    }
}
