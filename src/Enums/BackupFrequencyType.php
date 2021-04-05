<?php

namespace OZiTAG\Tager\Backend\Backup\Enums;

use OZiTAG\Tager\Backend\Core\Enums\Enum;

class BackupFrequencyType extends Enum
{
    const MINUTE = 'MINUTE';
    const DAY = 'DAY';
    const HOUR = 'HOUR';
    const MONTH = 'MONTH';
    const CUSTOM = 'CUSTOM';
}
