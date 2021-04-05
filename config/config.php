<?php

use \OZiTAG\Tager\Backend\Backup\Enums\BackupSourceType;

return [

    'auto_backup' => true,

    'sources' => [
        [
            'type' => BackupSourceType::DATABASE,
            'connection' => 'mysql',
        ],
//        [
//            'type' => BackupSourceType::FOLDER,
//            'path' => storage_path('app/public/uploads'),
//            'frequency' => [
//                'value' => 'everyTwoMinutes',
//            ],
//        ],
    ],

    'default_source' => [
        'temp_disk' => 'local',
        'temp_directory' => 'temp',
        'destination' => [
            'disk' => 'local',
            'path' => 'some_path'
        ],
        'frequency' => [
            'cron_value' => null,
            'value' => 'everyMinute',
        ],
        'encryption' => [
            'algorithm' => ZipArchive::EM_AES_256,
            'password' => 'qwerty',
        ],
        'archive_prefix' => '',
    ],
];
