<?php

namespace D4T\MT4Sdk\Exceptions;

use Exception;

class ActionFailed extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
