<?php

namespace App\Http\Actions\Employees;

use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class GetEmployeesWithoutRecentSalaryChange
{
    public function handle($request): LengthAwarePaginator
    {

        $cutoffDate = Carbon::now()->subMonths($request->months);

        return Employee::query()
            ->where(function ($query) use ($cutoffDate) {
                $query->where('last_salary_change_date', '<', $cutoffDate);
            })
            ->with(['employeePosition', 'manager'])
            ->orderByDesc('created_at')
            ->paginate(10);
    }
}
