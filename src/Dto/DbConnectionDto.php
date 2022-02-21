<?php

namespace OZiTAG\Tager\Backend\Backup\Dto;

use OZiTAG\Tager\Backend\Core\Dto\Dto;

class DbConnectionDto extends Dto
{
    protected string $driver;

    protected ?string $url;
    protected ?string $host;
    protected ?string $port;
    protected ?string $database;
    protected ?string $username;
    protected ?string $password;
    protected ?string $charset;

    public function __construct(array $data)
    {
        $this->setFromDataObject($data);
    }

    public function getDriver(): string {
        return $this->driver;
    }

    /**
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * @return string|null
     */
    public function getDatabase(): ?string
    {
        return $this->database;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getPort(): ?string
    {
        return $this->port;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }
}
