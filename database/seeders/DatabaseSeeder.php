<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeePosition;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        EmployeePosition::factory(10)->create();

        $founder = Employee::factory()->create([
            'name' => 'Yad | Founder',
            'email' => 'founder@example.com',
            'manager_id' => null,
        ]);

        $firstLevelManagers = Employee::factory(2)->create([
            'manager_id' => $founder->id,
        ]);

        $secondLevelManagers = Employee::factory(3)->create([
            'manager_id' => 2,
        ]);
        $secondLevelManagers = Employee::factory(3)->create([
            'manager_id' => 3,
        ]);

    }
}
