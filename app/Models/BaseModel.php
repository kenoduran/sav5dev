<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $incrementing = false; // Desactivar autoincremento
    protected $keyType = 'string'; // Definir clave primaria como string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generateNumericId();
            }
        });
    }

    // Función para generar un ID de 16 dígitos numéricos
    private static function generateNumericId()
    {
        $timestamp = substr(time(), -8); // Últimos 8 dígitos del timestamp
        $random = mt_rand(10000000, 99999999); // 8 dígitos aleatorios
        return $timestamp . $random; // 16 dígitos en total
    }
}
