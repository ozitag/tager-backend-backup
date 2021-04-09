<?php
namespace OZiTAG\Tager\Backend\Backup\Operations;

use Illuminate\Support\Facades\Storage;
use OZiTAG\Tager\Backend\Backup\Dto\FileSourceDto;
use OZiTAG\Tager\Backend\Backup\Facades\TagerBackup;
use OZiTAG\Tager\Backend\Backup\Jobs\CreateZipArchive;
use OZiTAG\Tager\Backend\Backup\Jobs\DeleteTempFile;
use OZiTAG\Tager\Backend\Backup\Jobs\SendZipToDisk;
use OZiTAG\Tager\Backend\Core\Jobs\Operation;

class CreateFileBackupOperation extends Operation
{
    public function __construct(
        protected FileSourceDto $source
    ) {}

    public function handle() {
        $zip_filename = $this->run(CreateZipArchive::class, [
            'path' => Storage::disk($this->source->getTempDisk())
                ->path($this->source->getTempDirectory()),
            'files' => [$this->source->getPath()],
            'enable_encryption' => TagerBackup::hasEncryption($this->source),
            'encryption' => $this->source->getEncryption(),
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
