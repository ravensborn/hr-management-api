<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveAllLogFiles extends Command
{
    protected $signature = 'app:remove-all-log-files';

    protected $description = 'Remove all log files in the storage/logs directory';

    public function handle(): int
    {
        $logFiles = File::files(storage_path('logs'));

        foreach ($logFiles as $file) {
            File::delete($file->getPathname());
        }

        $this->info('All log files have been removed.');

        return 0;
    }
}
