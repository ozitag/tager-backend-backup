<?php

namespace OZiTAG\Tager\Backend\Backup\Enums;

use OZiTAG\Tager\Backend\Core\Enums\Enum;

class BackupSourceType extends Enum
{
    const DATABASE = 'DATABASE';
    const FOLDER = 'FOLDER';
    const FILE = 'FILE';
}
