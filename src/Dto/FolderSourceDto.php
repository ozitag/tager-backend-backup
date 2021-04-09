<?php

namespace OZiTAG\Tager\Backend\Backup\Dto;

use OZiTAG\Tager\Backend\Backup\Exceptions\InvalidSourceConfigurationException;

class FolderSourceDto extends SourceDto
{
    protected string $path;

    public function __construct(array $data)
    {
        $this->path = $data['path'] ?? null;

        if (!$this->path) {
            throw InvalidSourceConfigurationException::pathNotFilled();
        }
        
        parent::__construct($data);
    }

    public function getPath(): string {
        return $this->path;
    }
}
