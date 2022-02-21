<?php

namespace OZiTAG\Tager\Backend\Backup\Dto;

use OZiTAG\Tager\Backend\Backup\Exceptions\InvalidSourceConfigurationException;
use OZiTAG\Tager\Backend\Core\Dto\Dto;

class SourceDto extends Dto
{
    protected string $type;
    protected ?string $archive_prefix;
    protected ?string $disk;
    protected ?string $temp_directory;
    protected ?string $temp_disk;

    protected SourceFrequencyDto $frequency_dto;
    protected SourceEncryptionDto $encryption_dto;
    protected SourceDestinationDto $destination_dto;

    public function __construct(array $data)
    {
        $this->setFromDataObject($data);
        if (!$this->type) {
            throw InvalidSourceConfigurationException::unsupportedType();
        }
        $this->frequency_dto = new SourceFrequencyDto($data['frequency'] ?? []);
        $this->encryption_dto = new SourceEncryptionDto($data['encryption'] ?? []);
        $this->destination_dto = new SourceDestinationDto($data['destination'] ?? []);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDisk(): ?string
    {
        return $this->disk;
    }

    public function getArchivePrefix(): ?string
    {
        return $this->archive_prefix;
    }

    public function getTempDirectory(): ?string
    {
        return $this->temp_directory;
    }

    public function getTempDisk(): ?string
    {
        return $this->temp_disk;
    }

    public function getEncryption(): SourceEncryptionDto
    {
        return $this->encryption_dto;
    }

    public function getFrequency(): SourceFrequencyDto
    {
        return $this->frequency_dto;
    }

    public function getDestination(): SourceDestinationDto
    {
        return $this->destination_dto;
    }
}
