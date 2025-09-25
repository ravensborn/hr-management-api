<?php

namespace Database\Factories;

use App\Models\EmployeePosition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'salary' => fake()->randomFloat(2, 30000, 150000),
            'manager_id' => 1,
            'employee_position_id' => fake()->randomElement(EmployeePosition::query()->inRandomOrder()->limit(4)->pluck('id')->toArray()),
        ];
    }
}
