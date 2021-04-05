<?php
namespace OZiTAG\Tager\Backend\Backup\Jobs\Database;

use Illuminate\Support\Facades\Config;
use OZiTAG\Tager\Backend\Backup\Dto\DbConnectionDto;
use OZiTAG\Tager\Backend\Backup\Exceptions\InvalidSourceConfigurationException;
use OZiTAG\Tager\Backend\Core\Jobs\Job;

class GetDatabaseConnection extends Job
{
    public function __construct(
        protected string $connection
    ) {}

    public function handle() {
        $connection = Config::get("database.connections." . $this->connection);

        if (!$connection) {
            throw InvalidSourceConfigurationException::invalidConnection();
        }
        
        return new DbConnectionDto($connection);
    }
}
