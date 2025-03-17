<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends BaseModel
{
    use HasFactory;

    protected $table = 'suppliers';

    // Los campos que puedes asignar masivamente
    protected $fillable = [
        'name',
        'alias',
        'tax_id',
        'email',
        'phone',
        'secondary_phone',
        'website',
        'contact_person',
        'contact_email',
        'contact_phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'notes',
    ];
}
