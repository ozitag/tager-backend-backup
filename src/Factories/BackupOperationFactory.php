<?php

namespace OZiTAG\Tager\Backend\Backup\Factories;

use OZiTAG\Tager\Backend\Backup\Dto\SourceDto;
use OZiTAG\Tager\Backend\Backup\Enums\BackupSourceType;
use OZiTAG\Tager\Backend\Backup\Exceptions\InvalidSourceConfigurationException;
use OZiTAG\Tager\Backend\Backup\Operations\CreateDatabaseBackupOperation;
use OZiTAG\Tager\Backend\Core\Jobs\Operation;

class BackupOperationFactory
{
    public static function getOperaion(SourceDto $source): Operation {
        return match ($source->getType()) {
            BackupSourceType::DATABASE => new CreateDatabaseBackupOperation($source),
            default => throw InvalidSourceConfigurationException::unsupportedType()
        };
    }
}