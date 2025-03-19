<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    use HasFactory;

    /**
     * The primary key is a string type instead of auto-incrementing integer
     */
    protected $keyType = 'string';

    /**
     * Turn off auto-incrementing for the primary key
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'code',
        'pic',
        'short_description',
        'long_description',
        'brand',
        'family',
        'price1',
        'price2',
        'price3',
        'cost',
        'min_stock',
        'max_stock',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price1' => 'decimal:2',
        'price2' => 'decimal:2',
        'price3' => 'decimal:2',
        'cost' => 'decimal:2',
        'min_stock' => 'integer',
        'max_stock' => 'integer',
    ];
}