<?php

namespace OZiTAG\Tager\Backend\Backup\DatabaseDumpers;

use OZiTAG\Tager\Backend\Backup\Dto\DatabaseSourceDto;
use OZiTAG\Tager\Backend\Backup\Dto\DbConnectionDto;

abstract class DatabaseDumper
{
    protected $temp_disk;
    protected $temp_directory;

    public function __construct(
        protected DbConnectionDto $conection
    ) {}

    public function setTempDestinationFromSource(DatabaseSourceDto $source) {
        $this->temp_disk = $source->getTempDisk();
        $this->temp_directory = $source->getTempDirectory();
    }

    public function getConnectionDump(): string {
        return $this->makeDump();
    }
    
    protected function makeDump(): string {}
}
