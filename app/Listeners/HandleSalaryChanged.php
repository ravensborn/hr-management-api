<?php

namespace App\Listeners;

use App\Events\ManagerSalaryNotification;
use App\Events\SalaryChanged;
use App\Mail\SalaryChangedMail;
use App\Models\Employee;
use Illuminate\Support\Facades\Mail;

class HandleSalaryChanged
{
    public function __construct() {}

    public function handle(SalaryChanged $event): void
    {
        Mail::to($event->employee->email)
            ->send(new SalaryChangedMail($event->employee));

        $managers = $this->getManagerHierarchy($event->employee);

        foreach ($managers as $manager) {
            broadcast(new ManagerSalaryNotification($manager, $event->employee));
        }
    }

    private function getManagerHierarchy(Employee $employee): array
    {
        $hierarchy = [];
        $current = $employee->manager;

        while ($current) {
            $hierarchy[] = $current;
            $current = $current->manager;
        }

        return $hierarchy;
    }
}
