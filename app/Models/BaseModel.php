<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    public $incrementing = false; // Desactivar el autoincremento
    protected $keyType = 'string'; // Definir la clave primaria como string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::random(25); // Generar ID aleatorio
            }
        });
    }
}
