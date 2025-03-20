<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectEmployee extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'employee_id',
        'role',
        'start_date',
        'end_date',
        'hours_allocated',
        'hourly_rate',
        'responsibilities',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'hours_allocated' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
    ];

    // Relaciones
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Calcular el costo total estimado para este empleado en el proyecto
    public function getEstimatedCostAttribute()
    {
        if ($this->hours_allocated && $this->hourly_rate) {
            return $this->hours_allocated * $this->hourly_rate;
        }
        return 0;
    }
}