<?php

namespace App\Http\Actions\Employees;

use App\Events\SalaryChanged;

class UpdateEmployeeAction
{
    public function handle($employee, $request): void
    {

        if ((float) $employee->salary !== (float) $request->salary) {

            event(new SalaryChanged($employee, $request->salary));
        }

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'salary' => $request->salary,
            'manager_id' => $request->is_founder ? null : $request->manager_id,
            'employee_position_id' => $request->employee_position_id,
        ]);
    }
}
