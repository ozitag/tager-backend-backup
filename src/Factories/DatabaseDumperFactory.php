<?php

namespace OZiTAG\Tager\Backend\Backup\Factories;

use OZiTAG\Tager\Backend\Backup\DatabaseDumpers\Drivers\MysqlDumper;
use OZiTAG\Tager\Backend\Backup\Dto\DbConnectionDto;
use OZiTAG\Tager\Backend\Backup\Exceptions\InvalidSourceConfigurationException;

class DatabaseDumperFactory
{
    public static function getDumper(DbConnectionDto $connection) {
        return match ($connection->getDriver()) {
            'mysql' => new MysqlDumper($connection),
            default => throw InvalidSourceConfigurationException::unsupportedDatabase()
        };
    }
}
