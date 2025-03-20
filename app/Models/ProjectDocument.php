<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectDocument extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'document_type',
        'description',
        'file_path',
        'upload_date',
        'uploaded_by',
        'version',
    ];

    protected $casts = [
        'upload_date' => 'datetime',
    ];

    // Relaciones
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function uploader()
    {
        return $this->belongsTo(Employee::class, 'uploaded_by');
    }

    // Obtener la URL del archivo
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}