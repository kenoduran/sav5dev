<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            TextColumn::make('id')->sortable()->toggleable()->searchable(),
            TextColumn::make('name')->sortable()->toggleable()->searchable(),
            TextColumn::make('alias')->sortable()->toggleable()->searchable(),
            TextColumn::make('tax_id')->sortable()->toggleable()->searchable(),
            TextColumn::make('email')->sortable()->toggleable()->searchable(),
            TextColumn::make('phone')->sortable()->toggleable()->searchable(),
            TextColumn::make('secondary_phone')->sortable()->toggleable()->searchable(),
            TextColumn::make('website')->sortable()->toggleable()->searchable(),
            TextColumn::make('contact_person')->sortable()->toggleable()->searchable(),
            TextColumn::make('contact_email')->sortable()->toggleable()->searchable(),
            TextColumn::make('contact_phone')->sortable()->toggleable()->searchable(),
            TextColumn::make('address')->sortable()->toggleable()->searchable(),
            TextColumn::make('city')->sortable()->toggleable()->searchable(),
            TextColumn::make('state')->sortable()->toggleable()->searchable(),
            TextColumn::make('zip_code')->sortable()->toggleable()->searchable(),
            TextColumn::make('country')->sortable()->toggleable()->searchable(),
            TextColumn::make('notes')->sortable()->toggleable()->searchable(),
            TextColumn::make('created_at')->sortable()->toggleable(),
            TextColumn::make('updated_at')->sortable()->toggleable(),
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
}
