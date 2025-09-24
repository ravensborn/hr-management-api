<?php

namespace App\Http\Requests\Employee;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DestroyEmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                if ($validator->failed()) {
                    return;
                }

                $employee = $this->route()->parameter('employee');

                if ($employee && $employee->subordinates()->count()) {
                    $validator->errors()->add(
                        'employee',
                        'Cannot delete an employee that has subordinates.',
                    );
                }

            }
        ];
    }

}
