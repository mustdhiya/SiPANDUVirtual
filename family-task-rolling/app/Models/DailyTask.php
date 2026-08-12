<?php

namespace App\tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DailyTask extends Model
{
    use SoftDeletes;

    protected $table = 'daily_tasks';

    protected $fillable = [
        'template_id',
        'family_id',
        'title',
        'description',
        'date',
        'status', // pending, in_progress, waiting_verification, completed, skipped, absent
        'due_at',
    ];

    protected $casts = [
        'date' => 'date',
        'due_at' => 'datetime',
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

    public function template(): BelongsTo
    {
        return $this->belongsTo(TaskTemplate::class, 'template_id');
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(TaskAssignment::class, 'daily_task_id');
    }

    public function history(): HasMany
    {
        return $this->hasMany(TaskHistory::class, 'daily_task_id');
    }

    public function verification(): HasOne
    {
        return $this->hasOne(TaskVerification::class, 'daily_task_id');
    }
}