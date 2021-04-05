<?php

namespace OZiTAG\Tager\Backend\Backup\Facades;

use Illuminate\Support\Facades\Facade;
use OZiTAG\Tager\Backend\Backup\Helpers\TagerBackupManager;

class TagerBackup extends Facade
{

    protected static function getFacadeAccessor()
    {
        return TagerBackupManager::class;
    }

}
