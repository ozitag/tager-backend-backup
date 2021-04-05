<?php

namespace OZiTAG\Tager\Backend\Backup\DatabaseDumpers\Drivers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OZiTAG\Tager\Backend\Backup\DatabaseDumpers\DatabaseDumper;
use OZiTAG\Tager\Backend\Backup\Exceptions\BackupException;
use OZiTAG\Tager\Backend\Backup\Exceptions\BackupFilesystemException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MysqlDumper extends DatabaseDumper
{
    private string $_secrets_filename_path;
    private ?string $_dump_path;

    protected function getDumpCommand()
    {
        $secrets_path = $this->setCredentialsFile();

        $command = [
            'mysqldump',
            "--defaults-extra-file=" . $secrets_path,
            $this->conection->getDatabase(),
        ];

        $this->_dump_path = implode('', [$this->temp_directory, '/', Str::orderedUuid(), '.sql']);

        $command[] = '> ' . Storage::disk($this->temp_disk)->path($this->_dump_path);

        return implode(' ', $command);
    }

    protected function makeDump(): string {
        $command = $this->getDumpCommand();

        $process = Process::fromShellCommandline($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new BackupException('Command dump exception');
        }

        $this->deleteSecretsFile();

        return $this->_dump_path;
    }

    protected function setCredentialsFile(): string {
        $file_data = [
            '[mysqldump]',
            "host = '{$this->conection->getHost()}'",
            "port = '{$this->conection->getPort()}'",
            "user = '{$this->conection->getUsername()}'",
            "password = '{$this->conection->getPassword()}'",
        ];

        $this->_secrets_filename_path = $this->temp_directory . '/.' . Str::orderedUuid();

        $result = Storage::disk($this->temp_disk)->put(
            $this->_secrets_filename_path,
            implode(PHP_EOL, $file_data)
        );

        !$result && throw BackupFilesystemException::unableToWriteFile();

        return Storage::disk($this->temp_disk)
            ->path($this->_secrets_filename_path);
    }

    protected function deleteSecretsFile(): void {
        Storage::disk($this->temp_disk)
            ->delete($this->_secrets_filename_path);
    }
}
