<?php

namespace App\Http\Actions\Employees;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ExportToCsvAction
{
    public function handle(): void
    {
        $writer = SimpleExcelWriter::streamDownload('employee-exports-'.Carbon::today()->toDateString().'-'.Str::random(5).'.csv');

        Employee::query()
            ->with(['employeePosition', 'manager'])
            ->chunk(1000, function ($employees) use ($writer) {
                foreach ($employees as $employee) {
                    $writer->addRow([
                        'Name' => $employee->name,
                        'Email' => $employee->email,
                        'Salary' => $employee->salary,
                        'Manager' => $employee->manager->name ?? 'Founder',
                        'Position' => $employee->employeePosition->name,
                        'Date Joined' => $employee->created_at->format('Y-m-d'),
                    ]);
                }
                flush();
            });

        $writer->toBrowser();

    }
}
