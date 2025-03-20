<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectTask extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'phase_id',
        'name',
        'description',
        'estimated_start_date',
        'estimated_end_date',
        'actual_start_date',
        'actual_end_date',
        'estimated_duration',
        'actual_duration',
        'progress_percentage',
        'status',
        'responsible_id',
        'priority',
    ];

    protected $casts = [
        'estimated_start_date' => 'date',
        'estimated_end_date' => 'date',
        'actual_start_date' => 'date',
        'actual_end_date' => 'date',
        'estimated_duration' => 'integer',
        'actual_duration' => 'integer',
        'progress_percentage' => 'decimal:2',
    ];

    // Relaciones
    public function phase()
    {
        return $this->belongsTo(ProjectPhase::class);
    }

    public function responsible()
    {
        return $this->belongsTo(Employee::class, 'responsible_id');
    }

    // Acceder al proyecto a través de la fase
    public function project()
    {
        return $this->phase->project;
    }
}