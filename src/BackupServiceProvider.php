<?php

namespace OZiTAG\Tager\Backend\Backup;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Config;
use OZiTAG\Tager\Backend\Backup\Console\InitiateBackupCommand;
use OZiTAG\Tager\Backend\Backup\Facades\TagerBackup;

class BackupServiceProvider extends RouteServiceProvider
{

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'tager-backup');

        $this->commands([InitiateBackupCommand::class,]);

        if (Config::get('tager-backup.auto_backup')) {
            $this->app->booted(fn () => TagerBackup::initAutoBackup());
        }
    }
}
