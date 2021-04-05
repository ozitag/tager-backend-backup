<?php
namespace OZiTAG\Tager\Backend\Backup\Jobs;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OZiTAG\Tager\Backend\Backup\Dto\SourceEncryptionDto;
use OZiTAG\Tager\Backend\Backup\Exceptions\BackupFilesystemException;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use \ZipArchive;

class CreateZipArchive extends Job
{
    public function __construct(
        protected array $files,
        protected string $path,
        protected bool $enable_encryption,
        protected SourceEncryptionDto $encryption,
    ) {}

    public function handle() {
        $zip = new ZipArchive();
        $zip_filename = $this->path . '/' . Str::orderedUuid() . '.zip';
        $res = $zip->open($zip_filename, ZipArchive::CREATE);

        if ($res !== true) {
            BackupFilesystemException::unableToWriteZipFile();
        }

        if ($this->enable_encryption) {
            $zip->setPassword($this->encryption->getPassword());
        }

        foreach ($this->files as $i => $file) {
            $file_parts = explode('/', $file);
            $filename = array_pop($file_parts);
            $zip->addFile($file, $filename);

            if ($this->enable_encryption) {
                $zip->setEncryptionName($filename, $this->encryption->getAlgorithm());
            }
        }

        $zip->close();

        return $zip_filename;
    }
}
