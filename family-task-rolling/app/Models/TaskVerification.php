<?php

namespace App\verification;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\tasks\TaskAssignment;
use App\tasks\DailyTask;

class TaskVerification extends Model
{
    use SoftDeletes;

    protected $table = 'task_verifications';

    protected $fillable = [
        'daily_task_id',
        'task_assignment_id',
        'verified_by',
        'status', // pending, approved, rejected
        'note',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const STATUS_PENDING   = 'pending';
    const STATUS_APPROVED  = 'approved';
    const STATUS_REJECTED  = 'rejected';

    public function dailyTask(): BelongsTo
    {
        return $this->belongsTo(DailyTask::class, 'daily_task_id');
    }

    public function taskAssignment(): BelongsTo
    {
        return $this->belongsTo(TaskAssignment::class, 'task_assignment_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(VerificationComment::class, 'verification_id');
    }

    public function evidencePhotos(): HasMany
    {
        return $this->hasMany(EvidencePhoto::class, 'verification_id');
    }
}