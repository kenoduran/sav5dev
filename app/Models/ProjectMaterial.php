<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectMaterial extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
        'unit',
        'assignment_date',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'assignment_date' => 'date',
    ];

    // Relaciones
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Calcular automáticamente el precio total al establecer cantidad o precio unitario
    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;
        $this->calculateTotalPrice();
    }

    public function setUnitPriceAttribute($value)
    {
        $this->attributes['unit_price'] = $value;
        $this->calculateTotalPrice();
    }

    private function calculateTotalPrice()
    {
        if (isset($this->attributes['quantity']) && isset($this->attributes['unit_price'])) {
            $this->attributes['total_price'] = $this->attributes['quantity'] * $this->attributes['unit_price'];
        }
    }
}