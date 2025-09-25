<?php

namespace App\Http\Actions\Employees;

class GenerateEmployeeHierarchyAction
{
    public function handle($employee): array
    {
        $hierarchy = [];
        $current = $employee->manager;

        while ($current) {
            $hierarchy[] = $current->toArray();
            $current = $current->manager;
        }

        return $hierarchy;
    }
}
