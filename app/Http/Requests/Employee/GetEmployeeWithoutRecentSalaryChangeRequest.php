<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class GetEmployeeWithoutRecentSalaryChangeRequest extends FormRequest
{
    public function rules(): array
    {
        return [

        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                if ($validator->failed()) {
                    return;
                }

                $months = $this->input('months');

                if (! is_numeric($months) || (int) $months != $months || (int) $months < 1 || (int) $months > 100) {
                    $validator->errors()->add(
                        'months',
                        'The months field must be an integer between 1 and 100.'
                    );
                }

            },
        ];
    }
}
