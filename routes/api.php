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
            Route::apiResource('employees', EmployeeController::class);
        });
});
