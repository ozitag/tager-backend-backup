<?php
namespace OZiTAG\Tager\Backend\Backup\Operations;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OZiTAG\Tager\Backend\Backup\Dto\DatabaseSourceDto;
use OZiTAG\Tager\Backend\Backup\Facades\TagerBackup;
use OZiTAG\Tager\Backend\Backup\Factories\DatabaseDumperFactory;
use OZiTAG\Tager\Backend\Backup\Jobs\CreateZipArchive;
use OZiTAG\Tager\Backend\Backup\Jobs\Database\GetDatabaseConnection;
use OZiTAG\Tager\Backend\Backup\Jobs\DeleteTempFile;
use OZiTAG\Tager\Backend\Backup\Jobs\SendZipToDisk;
use OZiTAG\Tager\Backend\Core\Jobs\Operation;

class CreateDatabaseBackupOperation extends Operation
{
    public function __construct(
        protected DatabaseSourceDto $source
    ) {}

    public function handle() {
        $connection = $this->run(GetDatabaseConnection::class, [
            'connection' => $this->source->getConnection()
        ]);

        $db_dumper = DatabaseDumperFactory::getDumper($connection);

        $db_dumper->setTempDestinationFromSource($this->source);
        $dump_path = $db_dumper->getConnectionDump();
        $dump_full_path = Storage::disk($this->source->getTempDisk())
            ->path($dump_path);

        $zip_filename = $this->run(CreateZipArchive::class, [
            'path' => Storage::disk($this->source->getTempDisk())
                ->path($this->source->getTempDirectory()),
            'files' => [$dump_full_path],
            'enable_encryption' => TagerBackup::hasEncryption($this->source),
            'encryption' => $this->source->getEncryption(),
        ]);

        $this->run(DeleteTempFile::class, [
            'file' => $dump_full_path,
        ]);
        
        $this->run(SendZipToDisk::class, [
            'file' => $zip_filename,
            'destination' => $this->source->getDestination()
        ]);

        $this->run(DeleteTempFile::class, [
            'file' => $zip_filename,
        ]);

    }
}
