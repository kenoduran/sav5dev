<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectExpense extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'description',
        'expense_type',
        'amount',
        'currency',
        'expense_date',
        'supplier',
        'receipt_number',
        'invoice_number',
        'payment_method',
        'status',
        'approved_by',
        'approval_date',
        'file_attachment',
        'notes',
        'billable',
        'reimbursable',
        'created_by',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'approval_date' => 'date',
        'amount' => 'decimal:2',
        'billable' => 'boolean',
        'reimbursable' => 'boolean',
    ];

    // Relaciones
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    // Obtener la URL del adjunto
    public function getAttachmentUrlAttribute()
    {
        if ($this->file_attachment) {
            return asset('storage/' . $this->file_attachment);
        }
        return null;
    }
}