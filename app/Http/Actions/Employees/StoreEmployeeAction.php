<?php

namespace App\Http\Actions\Employees;

use App\Events\EmployeeCreated;
use App\Models\Employee;

class StoreEmployeeAction
{
    public function handle($request): void
    {
        $employee = Employee::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'salary' => $request->salary,
            'manager_id' => $request->is_founder ? null : $request->manager_id,
            'employee_position_id' => $request->employee_position_id,
        ]);

        event(new EmployeeCreated($employee));
    }
}
