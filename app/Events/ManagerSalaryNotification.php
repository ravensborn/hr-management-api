<?php

namespace App\Events;

use App\Models\Employee;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ManagerSalaryNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Employee $manager,
        public Employee $employee
    ) {}

    public function broadcastOn(): array
    {
        return ['manager-channel-'.$this->manager->id];
    }

    public function broadcastAs(): string
    {
        return 'employee-salary-updated';
    }

    public function broadcastWith(): array
    {
        return [
            'employee_id' => $this->employee->id,
            'employee_name' => $this->employee->name,
            'salary' => $this->employee->salary,
        ];
    }
}
