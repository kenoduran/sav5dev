<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'customer_id',
        'contact_name',
        'contact_phone',
        'contact_email',
        'address',
        'city',
        'state',
        'zip_code',
        'gps_coordinates',
        'estimated_start_date',
        'estimated_end_date',
        'actual_start_date',
        'actual_end_date',
        'status',
        'progress_percentage',
        'total_budget',
        'current_cost',
        'estimated_margin',
        'currency',
        'project_type',
        'priority',
        'complexity',
        'construction_permit_number',
        'permit_date',
        'special_requirements',
        'additional_notes',
    ];

    protected $casts = [
        'estimated_start_date' => 'date',
        'estimated_end_date' => 'date',
        'actual_start_date' => 'date',
        'actual_end_date' => 'date',
        'permit_date' => 'date',
        'progress_percentage' => 'decimal:2',
        'total_budget' => 'decimal:2',
        'current_cost' => 'decimal:2',
        'estimated_margin' => 'decimal:2',
    ];

    // Relaciones
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function phases()
    {
        return $this->hasMany(ProjectPhase::class);
    }

    public function materials()
    {
        return $this->hasMany(ProjectMaterial::class);
    }

    public function employees()
    {
        return $this->hasMany(ProjectEmployee::class);
    }

    public function documents()
    {
        return $this->hasMany(ProjectDocument::class);
    }

    public function expenses()
    {
        return $this->hasMany(ProjectExpense::class);
    }

    // Accessor para calcular el margen actual
    public function getCurrentMarginAttribute()
    {
        if ($this->current_cost > 0) {
            $revenue = $this->total_budget;
            return (($revenue - $this->current_cost) / $revenue) * 100;
        }
        return 0;
    }

    // Accessor para calcular la variación presupuestaria
    public function getBudgetVarianceAttribute()
    {
        return $this->total_budget - $this->current_cost;
    }
}