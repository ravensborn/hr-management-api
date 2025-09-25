<?php

namespace App\Providers;

use App\Events\EmployeeCreated;
use App\Events\SalaryChanged;
use App\Listeners\HandleSalaryChanged;
use App\Listeners\SendManagerNotification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected array $listen = [
        EmployeeCreated::class => [
            SendManagerNotification::class,
        ],
        SalaryChanged::class => [
            HandleSalaryChanged::class,
        ],
    ];

    public function register(): void {}

    public function boot(): void {}
}
