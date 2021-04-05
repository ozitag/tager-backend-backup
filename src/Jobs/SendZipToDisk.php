<?php
namespace OZiTAG\Tager\Backend\Backup\Jobs;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OZiTAG\Tager\Backend\Backup\Dto\SourceDestinationDto;
use OZiTAG\Tager\Backend\Core\Jobs\Job;

class SendZipToDisk extends Job
{
    public function __construct(
        protected string $file,
        protected SourceDestinationDto $destination,
    ) {}

    public function handle() {
        Storage::disk($this->destination->getDisk())
            ->put(
                $this->destination->getPath() . '/'
                    . Carbon::now()->format('Y-m-d_H:i:s') 
                    . "_" . Str::orderedUuid() . '.zip',
                File::get($this->file)
            );
    }
}
