<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectPhase extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'estimated_start_date',
        'estimated_end_date',
        'actual_start_date',
        'actual_end_date',
        'progress_percentage',
        'status',
        'order',
    ];

    protected $casts = [
        'estimated_start_date' => 'date',
        'estimated_end_date' => 'date',
        'actual_start_date' => 'date',
        'actual_end_date' => 'date',
        'progress_percentage' => 'decimal:2',
        'order' => 'integer',
    ];

    protected $attributes = [
        'progress_percentage' => 0,
    ];

    // Relaciones
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class, 'phase_id');
    }

    // Ordenar por el campo 'order' por defecto
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($query) {
            $query->orderBy('order');
        });
    }
}