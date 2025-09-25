<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportDatabaseToSql extends Command
{
    protected $signature = 'app:export-database-to-sql {filename=backup.sql}';

    protected $description = 'Export the entire database to a SQL file';

    public function handle(): int
    {
        $filename = $this->argument('filename');
        $path = storage_path("app/$filename");

        $db = config('database.connections.mysql');

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            $db['username'],
            $db['password'],
            $db['host'],
            $db['database'],
            $path
        );

        $result = null;
        system($command, $result);

        if ($result === 0) {
            $this->info("Database exported to: $path");
        } else {
            $this->error("Database export failed.");
        }

        return $result;
    }
}
