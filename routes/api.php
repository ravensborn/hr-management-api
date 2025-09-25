<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePositionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/register', [UserController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')
        ->group(function () {

            Route::post('/logout', [UserController::class, 'logout'])->name('logout');
            Route::apiResource('employee-positions', EmployeePositionController::class);

            Route::name('employees.')->group(function () {
                Route::get('employees/{employee}/hierarchy', [EmployeeController::class, 'generateHierarchy'])->name('hierarchy');
                Route::get('employees/{employee}/hierarchy-with-salaries', [EmployeeController::class, 'generateHierarchyWithSalary'])->name('hierarchy-with-salaries');
                Route::get('employees/without-recent-salary-change', [EmployeeController::class, 'getEmployeesWithoutRecentSalaryChange'])->name('without-recent-salary-change');
                Route::get('employees/export', [EmployeeController::class, 'exportToCsv'])->name('export');
                Route::post('employees/import', [EmployeeController::class, 'importFromCsv'])->name('import');
                Route::apiResource('employees', EmployeeController::class);
            });

        });
});
