<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportEmployeesToJson extends Command
{
    protected $signature = 'app:export-employee-json {filename=employees.json}';

    protected $description = 'Export all employees to a JSON file';

    public function handle()
    {
        $filename = $this->argument('filename');
        $employees = Employee::query()->with(['employeePosition', 'manager'])->get();

        Storage::disk('local')->put($filename, $employees->toJson(JSON_PRETTY_PRINT));

        $this->info("Exported to: storage/app/$filename");

        return 0;
    }
}
