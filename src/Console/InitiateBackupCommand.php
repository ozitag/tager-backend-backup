<?php

namespace OZiTAG\Tager\Backend\Backup\Console;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use OZiTAG\Tager\Backend\Backup\Factories\BackupOperationFactory;
use OZiTAG\Tager\Backend\Backup\Factories\BackupSourceFactory;
use OZiTAG\Tager\Backend\Core\Console\Command;

class InitiateBackupCommand extends Command
{
    public $signature = 'tager-backend-backup {source_index}';

    public function handle() {
        $source_index = (int) $this->argument('source_index');

        $source_data = Config::get('tager-backup.sources')[$source_index] ?? null;
        if (!$source_data) {
            return;
        }

        dispatch_now(BackupOperationFactory::getOperaion(
            BackupSourceFactory::getSource($source_data)
        ));
    }
}
