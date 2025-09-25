<?php

namespace App\Http\Actions\Employees;

class DestroyEmployeeAction
{
    public function handle($employee): void
    {
        $employee->delete();
    }
}
