<?php

namespace OZiTAG\Tager\Backend\Backup\Exceptions;

use \Exception;

class BackupFilesystemException extends Exception
{
    public static function unableToWriteFile(): self
    {
        return new static('Unable to write file to disk');
    }
    
    public static function unableToWriteZipFile(): self
    {
        return new static('Unable to write zip-file to disk');
    }
}
