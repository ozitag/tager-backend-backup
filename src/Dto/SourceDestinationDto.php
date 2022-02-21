<?php

namespace OZiTAG\Tager\Backend\Backup\Dto;

use OZiTAG\Tager\Backend\Core\Dto\Dto;

class SourceDestinationDto extends Dto
{
    protected string $disk;
    protected ?string $path;

    public function __construct(array $data)
    {
        $this->setFromDataObject($data);
    }

    /**
     * @return string
     */
    public function getDisk(): string
    {
        return $this->disk;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }
}
