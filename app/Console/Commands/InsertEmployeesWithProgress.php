<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Faker\Factory as Faker;
use Illuminate\Console\Command;

class InsertEmployeesWithProgress extends Command
{
    protected $signature = 'app:insert-employees-with-progress {count}';

    protected $description = 'Insert employee records with a progress bar';

    public function handle(): int
    {
        $count = (int) $this->argument('count');
        $faker = Faker::create();

        $this->output->progressStart($count);

        for ($i = 0; $i < $count; $i++) {
            Employee::factory()->create();

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
        $this->info("Inserted $count employee records.");

        return 0;
    }
}
