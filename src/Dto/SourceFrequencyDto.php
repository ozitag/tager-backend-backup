<?php

namespace OZiTAG\Tager\Backend\Backup\Dto;

use OZiTAG\Tager\Backend\Backup\Exceptions\InvalidSourceConfigurationException;
use OZiTAG\Tager\Backend\Core\Dto\Dto;

class SourceFrequencyDto extends Dto
{
    protected ?string $function;
    protected array $args = [];

    public function __construct(array $data)
    {
        $this->function = $data['value'] ?? null;

        if (!$this->function) {
            $this->function = 'cron';
            $value = $data['cron_value'] ?? null;

            if (!$value) {
                throw InvalidSourceConfigurationException::invalidFrequency();
            }

            $this->args = [$value];
        }
    }

    public function getFunction(): string
    {
        return $this->function;
    }

    public function getArgs(): array
    {
        return $this->args;
    }
}
