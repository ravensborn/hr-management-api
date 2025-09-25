<?php

namespace App\Jobs;

use App\Models\Employee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class EmployeeSpreadsheetImport implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 18000;

    public function __construct(private readonly string $filePath) {}

    public function handle(): void
    {

        $this->importData();
        $this->cleanupFile();
    }

    private function importData(): void
    {
        SimpleExcelReader::create(Storage::disk('local')->path($this->filePath))
            ->headersToSnakeCase()
            ->preserveDateTimeFormatting()
            ->getRows()
            ->map(fn ($row) => $this->prepareRowData($row))
            ->filter()
            ->chunk(1000)
            ->each(fn ($dataChunk) => Employee::query()->insertOrIgnore($dataChunk->toArray()));
    }

    private function prepareRowData($row): array
    {
        return [
            'name' => $row['name'] ?? ' - ',
            'email' => $row['email'] ?? ' - ',
            'salary' => $row['salary'] ?? 0,
            'manager_id' => $row['manager'] ?? 1,
            'employee_position_id' => $row['position'] ?? 1,
        ];
    }

    private function cleanupFile(): void
    {
        if (Storage::disk('local')->exists($this->filePath)) {
            Storage::disk('local')->delete($this->filePath);
        }
    }
}
