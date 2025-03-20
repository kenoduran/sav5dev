<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            
            // Datos del cliente
            $table->string('customer_id', 20);
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            
            // Ubicación del proyecto
            $table->text('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('gps_coordinates')->nullable();
            
            // Fechas importantes
            $table->date('estimated_start_date');
            $table->date('estimated_end_date');
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            
            // Estado y progreso
            $table->enum('status', ['Proposal', 'Approved', 'Planning', 'In Progress', 'On Hold', 'Cancelled', 'Completed'])->default('Proposal');
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            
            // Datos financieros
            $table->decimal('total_budget', 15, 2);
            $table->decimal('current_cost', 15, 2)->default(0.00);
            $table->decimal('estimated_margin', 5, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            
            // Tipo y categorización
            $table->enum('project_type', ['Construction', 'Remodeling', 'Electrical', 'Plumbing', 'HVAC', 'Other']);
            $table->enum('priority', ['Low', 'Medium', 'High', 'Urgent'])->default('Medium');
            $table->enum('complexity', ['Low', 'Medium', 'High', 'Very High'])->default('Medium');
            
            // Otros datos importantes
            $table->string('construction_permit_number')->nullable();
            $table->date('permit_date')->nullable();
            $table->text('special_requirements')->nullable();
            $table->text('additional_notes')->nullable();
            
            $table->timestamps();
            
            // Relaciones
            $table->foreign('customer_id')->references('id')->on('customers');
        });
        
        // Tabla para fases o etapas del proyecto
        Schema::create('project_phases', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('project_id', 20);
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('estimated_start_date')->nullable();
            $table->date('estimated_end_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Cancelled'])->default('Pending');
            $table->integer('order');
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
        
        // Tabla para tareas específicas dentro de cada fase
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('phase_id', 20);
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('estimated_start_date')->nullable();
            $table->date('estimated_end_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->integer('estimated_duration')->nullable(); // en horas
            $table->integer('actual_duration')->nullable(); // en horas
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Cancelled'])->default('Pending');
            $table->string('responsible_id', 20)->nullable();
            $table->enum('priority', ['Low', 'Medium', 'High', 'Urgent'])->default('Medium');
            $table->timestamps();
            
            $table->foreign('phase_id')->references('id')->on('project_phases')->onDelete('cascade');
            $table->foreign('responsible_id')->references('id')->on('employees');
        });
        
        // Tabla para materiales (productos) asignados al proyecto
        Schema::create('project_materials', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('project_id', 20);
            $table->string('product_id', 20);
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('unit', 20)->nullable();
            $table->date('assignment_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');
        });
        
        // Tabla para asignar empleados a proyectos
        Schema::create('project_employees', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('project_id', 20);
            $table->string('employee_id', 20);
            $table->string('role'); // Rol específico en el proyecto
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('hours_allocated', 8, 2)->nullable(); // Horas asignadas
            $table->decimal('hourly_rate', 10, 2)->nullable(); // Tarifa por hora para este proyecto
            $table->text('responsibilities')->nullable(); // Responsabilidades específicas
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
        
        // Tabla para documentos relacionados con el proyecto
        Schema::create('project_documents', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('project_id', 20);
            $table->string('name');
            $table->enum('document_type', ['Contract', 'Blueprint', 'Permit', 'Invoice', 'Budget', 'Report', 'Other']);
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->timestamp('upload_date')->useCurrent();
            $table->string('uploaded_by', 20); // ID del empleado que subió el documento
            $table->string('version')->default('1.0');
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('employees');
        });
        
        // Tabla para gastos del proyecto
        Schema::create('project_expenses', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('project_id', 20);
            $table->string('description');
            $table->enum('expense_type', [
                'Materials', 
                'Equipment', 
                'Labor', 
                'Subcontractor', 
                'Permits', 
                'Transportation', 
                'Food', 
                'Accommodation', 
                'Tools', 
                'Utilities', 
                'Insurance', 
                'Taxes', 
                'Other'
            ]);
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->date('expense_date');
            $table->string('supplier')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Paid'])->default('Pending');
            $table->string('approved_by', 20)->nullable();
            $table->date('approval_date')->nullable();
            $table->string('file_attachment')->nullable(); // Ruta a imagen del recibo/factura
            $table->text('notes')->nullable();
            $table->boolean('billable')->default(true); // Si el gasto es facturable al cliente
            $table->boolean('reimbursable')->default(false); // Si es un gasto reembolsable
            $table->string('created_by', 20); // Empleado que registró el gasto
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('employees');
            $table->foreign('created_by')->references('id')->on('employees');
        });
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     
        Schema::dropIfExists('project_expenses');
        Schema::dropIfExists('project_documents');
        Schema::dropIfExists('project_employees');
        Schema::dropIfExists('project_materials');
        Schema::dropIfExists('project_tasks');
        Schema::dropIfExists('project_phases');
        Schema::dropIfExists('projects');
    }
};