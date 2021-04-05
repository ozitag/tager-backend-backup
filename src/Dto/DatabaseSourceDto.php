<?php

namespace OZiTAG\Tager\Backend\Backup\Dto;

use OZiTAG\Tager\Backend\Backup\Exceptions\InvalidSourceConfigurationException;

class DatabaseSourceDto extends SourceDto
{
    protected string $connection;

    public function __construct(array $data)
    {
        $this->connection = $data['connection'] ?? null;

        if (!$this->connection) {
            throw InvalidSourceConfigurationException::invalidConnection();
        }
        
        parent::__construct($data);
    }

    public function getConnection(): string {
        return $this->connection;
    }
}
