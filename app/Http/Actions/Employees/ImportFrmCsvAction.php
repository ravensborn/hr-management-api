<?php

namespace App\Http\Actions\Employees;

use App\Jobs\EmployeeSpreadsheetImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportFrmCsvAction
{
    public function handle($request): void
    {

        $path = Storage::disk('local')->put('imported-files', $request->file('file'));

        Log::channel('employee')->info('Uploaded new csv file', [
            'path' => $path,
        ]);

        dispatch(new EmployeeSpreadsheetImport($path));

    }
}
