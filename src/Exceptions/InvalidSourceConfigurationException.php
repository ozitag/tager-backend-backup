<?php

namespace OZiTAG\Tager\Backend\Backup\Exceptions;

use \Exception;

class InvalidSourceConfigurationException extends Exception
{
    public static function unsupportedType(): self
    {
        return new static('Unsupported source type');
    }
    
    public static function unsupportedDatabase(): self
    {
        return new static('Unsupported database');
    }

    public static function invalidFrequency(): self
    {
        return new static('Invalid frequency');
    }

    public static function invalidConnection(): self
    {
        return new static('Invalid connection name');
    }

    public static function invalidFrequencyValue(): self
    {
        return new static('Invalid frequency value');
    }

    public static function frequencyNotFilled(): self
    {
        return new static('Frequency not filled');
    }

    public static function pathNotFilled(): self
    {
        return new static('path not filled');
    }
}
