<?php

namespace App\Http\Actions\Employees;

use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ListEmployeeAction
{
    public function handle(): LengthAwarePaginator
    {
        return QueryBuilder::for(Employee::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::exact('salary'),
            ])
            ->with(['employeePosition', 'manager'])
            ->orderByDesc('created_at')
            ->paginate(10);
    }
}
