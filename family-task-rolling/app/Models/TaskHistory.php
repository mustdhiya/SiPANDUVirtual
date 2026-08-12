<?php

namespace App\tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class TaskHistory extends Model
{
    protected $table = 'task_histories';

    protected $fillable = [
        'daily_task_id',
        'task_assignment_id',
        'actor_id',
        'action_type', // created, started, submitted_for_verification, verified, rejected, status_changed, marked_absent, skipped
        'old_status',
        'new_status',
        'note',
        'metadata', // JSON
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function dailyTask(): BelongsTo
    {
        return $this->belongsTo(DailyTask::class, 'daily_task_id');
    }

    public function taskAssignment(): BelongsTo
    {
        return $this->belongsTo(TaskAssignment::class, 'task_assignment_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}