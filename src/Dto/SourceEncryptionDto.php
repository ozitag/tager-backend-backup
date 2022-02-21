<?php

namespace OZiTAG\Tager\Backend\Backup\Dto;

use \ZipArchive;
use OZiTAG\Tager\Backend\Core\Dto\Dto;

class SourceEncryptionDto extends Dto
{
    protected ?string $algorithm;
    protected ?string $password;

    public function __construct(array $data)
    {
        $this->setFromDataObject($data);
    }

    public function getAlgorithm(): int {
        return $this->algorithm ?: ZipArchive::EM_AES_256;
    }

    public function getOriginalAlgorithm(): ?string {
        return $this->algorithm;
    }

    public function getPassword(): ?string {
        return $this->password;
    }
}
