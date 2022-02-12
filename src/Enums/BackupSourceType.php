<?php

namespace OZiTAG\Tager\Backend\Backup\Enums;

enum BackupSourceType: string
{
    case DATABASE = 'DATABASE';
    case FOLDER = 'FOLDER';
    case FILE = 'FILE';
}
