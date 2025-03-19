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
        Schema::create('products', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('code');
            $table->string('pic')->nullable();
            $table->string('short_description');
            $table->text('long_description')->nullable();
            $table->string('brand');
            $table->string('family');
            $table->decimal('price1', 10, 2);
            $table->decimal('price2', 10, 2)->nullable();
            $table->decimal('price3', 10, 2)->nullable();
            $table->decimal('cost', 10, 2);
            $table->integer('min_stock')->default(0);
            $table->integer('max_stock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};