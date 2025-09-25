<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePositionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->middleware('throttle:10,1')->group(function () {

    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/register', [UserController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')
        ->group(function () {

            Route::post('/logout', [UserController::class, 'logout'])->name('logout');
            Route::apiResource('employee-positions', EmployeePositionController::class);

            Route::prefix('employees')
                ->name('employees.')
                ->controller(EmployeeController::class)
                ->group(function () {
                    Route::get('{employee}/hierarchy', 'generateHierarchy')->name('hierarchy');
                    Route::get('{employee}/hierarchy-with-salaries', 'generateHierarchyWithSalary')->name('hierarchy-with-salaries');
                    Route::get('without-recent-salary-change', 'getEmployeesWithoutRecentSalaryChange')->name('without-recent-salary-change');
                    Route::get('export', 'exportToCsv')->name('export');
                    Route::post('import', 'importFromCsv')->name('import');

                    Route::apiResource('/', EmployeeController::class)->parameters(['' => 'employee']);
                });

        });
});
