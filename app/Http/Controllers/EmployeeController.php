<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\DestroyEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\Employee\EmployeeCollection;
use App\Models\Employee;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = QueryBuilder::for(Employee::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::exact('salary'),
            ])
            ->with(['employeePosition', 'manager'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json(new EmployeeCollection($employees));
    }

    public function store(StoreEmployeeRequest $request)
    {
        Employee::query()->create([
            'name' => $request->name,
            'salary' => $request->salary,
            'manager_id' => $request->is_founder ? null : $request->manager_id,
            'employee_position_id' => $request->employee_position_id,
        ]);
        return response()->noContent(HttpStatus::HTTP_CREATED);
    }

    public function update(Employee $employee, UpdateEmployeeRequest $request)
    {
        $employee->update([
            'name' => $request->name,
            'salary' => $request->salary,
            'manager_id' => $request->is_founder ? null : $request->manager_id,
            'employee_position_id' => $request->employee_position_id,
        ]);
        return response()->noContent(HttpStatus::HTTP_CREATED);
    }

    public function destroy(Employee $employee, DestroyEmployeeRequest $request) {
        $employee->delete();
        return response()->noContent(HttpStatus::HTTP_OK);
    }


}
