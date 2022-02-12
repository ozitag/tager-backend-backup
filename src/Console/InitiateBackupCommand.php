<?php

namespace OZiTAG\Tager\Backend\Backup\Console;

use Illuminate\Support\Facades\Config;
use OZiTAG\Tager\Backend\Backup\Factories\BackupOperationFactory;
use OZiTAG\Tager\Backend\Backup\Factories\BackupSourceFactory;
use OZiTAG\Tager\Backend\Core\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;

class InitiateBackupCommand extends Command
{
    public $signature = 'tager-backend-backup {source_index}';

    public function handle() {
        $source_index = (int) $this->argument('source_index');

        $source_data = Config::get('tager-backup.sources')[$source_index] ?? null;
        if (!$source_data) {
            return;
        }

        app(Dispatcher::class)->dispatchNow(BackupOperationFactory::getOperation(
            BackupSourceFactory::getSource($source_data)
        ));
    }
}
