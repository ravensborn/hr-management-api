<?php

namespace App\Http\Controllers;

use App\Http\Actions\Employees\DestroyEmployeeAction;
use App\Http\Actions\Employees\ExportToCsvAction;
use App\Http\Actions\Employees\GenerateEmployeeHierarchyAction;
use App\Http\Actions\Employees\GetEmployeesWithoutRecentSalaryChange;
use App\Http\Actions\Employees\ImportFrmCsvAction;
use App\Http\Actions\Employees\ListEmployeeAction;
use App\Http\Actions\Employees\StoreEmployeeAction;
use App\Http\Actions\Employees\UpdateEmployeeAction;
use App\Http\Requests\Employee\DestroyEmployeeRequest;
use App\Http\Requests\Employee\GetEmployeeWithoutRecentSalaryChangeRequest;
use App\Http\Requests\Employee\Import\ImportRequest;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\Employee\EmployeeCollection;
use App\Http\Resources\Employee\Hierarchy\EmployeeHierarchyCollection;
use App\Http\Resources\Employee\Hierarchy\EmployeeHierarchyWithSalaryCollection;
use App\Http\Resources\Employee\WithoutRecentSalaryChange\EmployeeWithoutRecentSalaryChangeCollection;
use App\Models\Employee;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class EmployeeController extends Controller
{
    public function index(ListEmployeeAction $action)
    {
        return response()->json(new EmployeeCollection($action->handle()));
    }

    public function generateHierarchy(Employee $employee, GenerateEmployeeHierarchyAction $action)
    {
        return response()->json(new EmployeeHierarchyCollection($action->handle($employee)));
    }

    public function generateHierarchyWithSalary(Employee $employee, GenerateEmployeeHierarchyAction $action)
    {
        return response()->json(new EmployeeHierarchyWithSalaryCollection($action->handle($employee)));
    }

    public function getEmployeesWithoutRecentSalaryChange(GetEmployeeWithoutRecentSalaryChangeRequest $request, GetEmployeesWithoutRecentSalaryChange $action)
    {
        return response()->json(new EmployeeWithoutRecentSalaryChangeCollection($action->handle($request)));

    }

    public function store(StoreEmployeeRequest $request, StoreEmployeeAction $action)
    {
        $action->handle($request);

        return response()->noContent(HttpStatus::HTTP_CREATED);
    }

    public function update(Employee $employee, UpdateEmployeeRequest $request, UpdateEmployeeAction $action)
    {
        $action->handle($employee, $request);

        return response()->noContent(HttpStatus::HTTP_CREATED);
    }

    public function destroy(Employee $employee, DestroyEmployeeRequest $request, DestroyEmployeeAction $action)
    {
        $action->handle($employee);

        return response()->noContent(HttpStatus::HTTP_OK);
    }

    public function exportToCsv(ExportToCsvAction $action)
    {
        return response()->streamDownload(function () use ($action) {
            $action->handle();
        });
    }

    public function importFromCsv(ImportRequest $request, ImportFrmCsvAction $action)
    {
        $action->handle($request);

        return response()->noContent(HttpStatus::HTTP_OK);
    }
}
