<?php
namespace OZiTAG\Tager\Backend\Backup\Jobs;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use OZiTAG\Tager\Backend\Core\Jobs\Job;

class DeleteTempFile extends Job
{
    public function __construct(
        protected string $file,
    ) {}

    public function handle() {
        File::delete($this->file);
    }
}
