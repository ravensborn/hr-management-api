<?php

namespace App\Http\Resources\Employee\WithoutRecentSalaryChange;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeWithoutRecentSalaryChangeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'salary' => $this->salary,
            'last_salary_change_date' => $this->last_salary_change_date->diffForHumans(),
            'position' => $this->employeePosition->name,
            'manager' => $this->when($this->manager_id, function () {
                return [
                    'id' => $this->manager->id,
                    'name' => $this->manager->name,
                ];
            }),
            'is_founder' => $this->when(! $this->manager_id, true),
        ];
    }
}
