<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteOldEmployeeLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee-logs:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete logs older than one month of employee logs table';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $count = DB::table('audits')
            ->where('created_at', '<', now()->subMonth())
            ->delete();

        $this->info("Deleted $count old logs.");

        return 0;
    }
}
