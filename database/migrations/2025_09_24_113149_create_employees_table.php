<?php

use App\Models\Employee;
use App\Models\EmployeePosition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->decimal('salary', 10, 2);
            $table->foreignIdFor(Employee::class, 'manager_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->restrictOnUpdate();
            $table->foreignIdFor(EmployeePosition::class)
                ->constrained()
                ->restrictOnDelete()
                ->restrictOnUpdate();
            $table->dateTime('last_salary_change_date')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
