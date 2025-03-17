<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name'); // Cambiado a un solo campo 'name'
            $table->string('alias')->nullable();
            $table->string('employee_id')->nullable(); // Campo empleado, si es necesario
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('position')->nullable(); // Puesto
            $table->string('department')->nullable(); // Departamento
            $table->date('hire_date')->nullable(); // Fecha de contratación
            $table->decimal('salary', 10, 2)->nullable(); // Salario
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
}
