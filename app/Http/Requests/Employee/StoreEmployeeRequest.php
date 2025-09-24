<?php

namespace App\Http\Requests\Employee;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreEmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'is_founder' => 'required|boolean',

            'manager_id' => [
                'nullable',
                'required_if:is_founder,false',
                'prohibited_if:is_founder,true',
                'integer',
                'exists:employees,id',
            ],

            'employee_position_id' => 'required|integer|exists:employee_positions,id',
        ];
    }


    public function after(): array
    {
        return [
            function (Validator $validator) {

                if ($validator->failed()) {
                    return;
                }


                if ($this->request->getBoolean('is_founder')) {

                    $founderExists = Employee::query()
                        ->whereNull('manager_id')
                        ->exists();

                    if ($founderExists) {
                        $validator->errors()->add(
                            'is_founder',
                            'There can be only one founder!'
                        );
                    }
                }

            }
        ];
    }

}
