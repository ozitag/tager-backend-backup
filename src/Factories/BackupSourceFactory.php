<?php

namespace OZiTAG\Tager\Backend\Backup\Factories;

use Illuminate\Support\Facades\Config;
use OZiTAG\Tager\Backend\Backup\Dto\DatabaseSourceDto;
use OZiTAG\Tager\Backend\Backup\Dto\SourceDto;
use OZiTAG\Tager\Backend\Backup\Enums\BackupSourceType;
use OZiTAG\Tager\Backend\Backup\Exceptions\InvalidSourceConfigurationException;

class BackupSourceFactory
{
    public static function getSource(array $source_data): SourceDto {
        $source_data = array_merge(Config::get('tager-backup.default_source'), $source_data);

        return match ($source_data['type'] ?? null) {
            BackupSourceType::DATABASE => new DatabaseSourceDto($source_data),
            default => throw InvalidSourceConfigurationException::unsupportedType()
        };
    }
}
