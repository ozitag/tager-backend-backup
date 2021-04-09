<?php
namespace OZiTAG\Tager\Backend\Backup\Jobs;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OZiTAG\Tager\Backend\Backup\Dto\SourceDto;
use OZiTAG\Tager\Backend\Backup\Dto\SourceEncryptionDto;
use OZiTAG\Tager\Backend\Backup\Exceptions\BackupFilesystemException;
use OZiTAG\Tager\Backend\Backup\Facades\TagerBackup;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use \ZipArchive;

class CreateZipArchive extends Job
{
    public function __construct(
        protected string $path,
        protected bool $enable_encryption,
        protected SourceEncryptionDto $encryption,
        protected array $files = [],
        protected ?string $folder = null,
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

        if ($this->folder) {
            $folder_files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($this->folder), \RecursiveIteratorIterator::LEAVES_ONLY
            );
            foreach ($folder_files as $name => $file)
            {
                if (!$file->isDir()) {
                    $file_path = $file->getRealPath();
                    $relative_path = substr($file_path, strlen($this->folder) + 1);
                    $this->addFileToZip($zip, $file_path, $relative_path);
                }
            }
        }

        foreach ($this->files as $i => $file) {
            $file_parts = explode('/', $file);
            $filename = array_pop($file_parts);
            $this->addFileToZip($zip, $file, $filename);
        }

        $zip->close();

        return $zip_filename;
    }

    private function addFileToZip(&$zip, $file, $relative_path) {
        $zip->addFile($file, $relative_path);

        if ($this->enable_encryption) {
            $zip->setEncryptionName($relative_path, $this->encryption->getAlgorithm());
        }
    }
}
