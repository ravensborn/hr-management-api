<?php

namespace App\Http\Requests\EmployeePosition;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateEmployeePositionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
