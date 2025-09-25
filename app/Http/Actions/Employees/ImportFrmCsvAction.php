<?php

namespace App\Http\Actions\Employees;

use App\Jobs\EmployeeSpreadsheetImport;
use Illuminate\Support\Facades\Storage;

class ImportFrmCsvAction
{
    public function handle($request): void
    {

        $path = Storage::disk('local')->put('imported-files', $request->file('file'));

        dispatch(new EmployeeSpreadsheetImport($path));

    }
}
