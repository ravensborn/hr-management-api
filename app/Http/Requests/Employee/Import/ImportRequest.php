<?php

namespace App\Http\Requests\Employee\Import;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:csv|max:10240',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                if ($validator->failed()) {
                    return false;
                }

                $file = request()->file('file');

                $headings = SimpleExcelReader::create($file, $file->extension())
                    ->headersToSnakeCase()
                    ->getHeaders();

                $requiredHeadings = ['name', 'email', 'salary', 'manager', 'position'];
                $headings = collect($headings);

                if ($headings->isEmpty()) {
                    $validator->errors()->add('file', 'Spreadsheet file has no records.');

                    return false;
                }

                if ($headings->duplicates()->isNotEmpty()) {
                    $validator->errors()->add('file', 'Spreadsheet has duplicate column names.');

                    return false;
                }

                foreach ($requiredHeadings as $requiredColumn) {
                    if (! $headings->contains($requiredColumn)) {
                        $validator->errors()->add('file', "Spreadsheet does not contain $requiredColumn column.");

                        return false;
                    }
                }

                return true;

            },
        ];
    }
}
