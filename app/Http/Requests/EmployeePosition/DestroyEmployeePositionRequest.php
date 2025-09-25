<?php

namespace App\Http\Requests\EmployeePosition;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DestroyEmployeePositionRequest extends FormRequest
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

                $employeePosition = $this->route()->parameter('employee_position');

                if ($employeePosition && $employeePosition->employees()->count()) {
                    $validator->errors()->add(
                        'employee',
                        'Cannot delete a position that has employees attached.',
                    );
                }

            },
        ];
    }
}
