<?php

namespace App\audit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class AuditLog extends Model
{
    // Tidak pakai soft delete, karena audit harus immutable
    // public $timestamps = false; // kalau mau benar2 immutable, tapi kita tetap pakai created_at

    protected $table = 'audit_logs';

    protected $fillable = [
        'actor_id',
        'action_type', // user_login, task_assigned, task_status_changed, skip_requested, skip_approved, etc.
        'entity_type', // user, task_assignment, daily_task, skip_request, etc.
        'entity_id',
        'old_values', // JSON
        'new_values', // JSON
        'ip_address',
        'user_agent',
        'note',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Tidak boleh update/delete, tapi di level model kita tidak enforce keras,
    // nanti di service layer kita tidak pernah update/delete.

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}