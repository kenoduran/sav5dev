<?php

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
        Schema::create('tools', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name');
            $table->string('type');
            $table->string('model');
            $table->string('manufacturer');
            $table->date('purchase_date');
            $table->decimal('cost', 15, 2);
            $table->string('serial_number')->nullable();
            $table->string('location');
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_maintenance_due')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};