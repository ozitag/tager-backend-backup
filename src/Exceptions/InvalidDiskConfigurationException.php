<?php

namespace OZiTAG\Tager\Backend\Backup\Exceptions;

use \Exception;
use Throwable;

class InvalidDiskConfigurationException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
