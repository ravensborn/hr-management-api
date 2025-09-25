<?php

namespace App\Listeners;

use App\Events\EmployeeCreated;
use App\Mail\ManagerNotification;
use Illuminate\Support\Facades\Mail;

class SendManagerNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EmployeeCreated $event): void
    {
        $manager = $event->employee->manager;

        if ($manager && $manager->email) {
            Mail::to($manager->email)->send(new ManagerNotification($event->employee));
        }
    }
}
