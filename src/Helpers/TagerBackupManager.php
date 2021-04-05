<?php

namespace OZiTAG\Tager\Backend\Backup\Helpers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Facade;
use OZiTAG\Tager\Backend\Backup\Dto\SourceDto;
use OZiTAG\Tager\Backend\Backup\Dto\SourceFrequencyDto;
use OZiTAG\Tager\Backend\Backup\Exceptions\InvalidSourceConfigurationException;
use OZiTAG\Tager\Backend\Backup\Factories\BackupSourceFactory;

class TagerBackupManager
{

    public function initAutoBackup(): void
    {
        return;
        $sources = Config::get('tager-backup.sources');
        if (!$sources) {
            return;
        }

        $frequency = Config::get('tager-backup.default_source.frequency');
        $schedule = App::make(Schedule::class);

        foreach ($sources as $index => $source_data) {
            $source = BackupSourceFactory::getSource($source_data);

            $function = $source->getFrequency()->getFunction();
            $command = $schedule->command('tager-backend-backup', [$index]);

            if (!method_exists($command, $function)) {
                throw InvalidSourceConfigurationException::invalidFrequencyValue();
            }

            $command->$function($source->getFrequency()->getArgs());
        }
    }

    public function hasEncryption(SourceDto $source): bool
    {
        if ($source->getEncryption()->getPassword() === null) {
            return false;
        }

        if ($source->getEncryption()->getOriginalAlgorithm() === null) {
            return false;
        }

        return true;
    }

}
