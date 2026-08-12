<?php

namespace App\tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class TaskAssignment extends Model
{
    use SoftDeletes;

    protected $table = 'task_assignments';

    protected $fillable = [
        'daily_task_id',
        'assigned_to',
        'assigned_by',
        'status', // pending, in_progress, waiting_verification, completed, skipped, absent
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const STATUS_PENDING            = 'pending';
    const STATUS_IN_PROGRESS        = 'in_progress';
    const STATUS_WAITING_VERIFICATION = 'waiting_verification';
    const STATUS_COMPLETED          = 'completed';
    const STATUS_SKIPPED            = 'skipped';
    const STATUS_ABSENT             = 'absent';

    public function dailyTask(): BelongsTo
    {
        return $this->belongsTo(DailyTask::class, 'daily_task_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function history(): HasMany
    {
        return $this->hasMany(TaskHistory::class, 'task_assignment_id');
    }

    public function verification(): HasMany
    {
        return $this->hasMany(TaskVerification::class, 'task_assignment_id');
    }
}