<?php

namespace App\verification;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\tasks\TaskAssignment;

class SkipRequest extends Model
{
    use SoftDeletes;

    protected $table = 'skip_requests';

    protected $fillable = [
        'task_assignment_id',
        'requested_by',
        'reason_code', // rain, power_outage, tool_unavailable, other
        'reason_detail',
        'status', // pending, approved, rejected
        'reviewed_by',
        'reviewed_at',
        'review_note',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const STATUS_PENDING  = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    const REASON_RAIN            = 'rain';
    const REASON_POWER_OUTAGE    = 'power_outage';
    const REASON_TOOL_UNAVAILABLE= 'tool_unavailable';
    const REASON_OTHER           = 'other';

    public function taskAssignment(): BelongsTo
    {
        return $this->belongsTo(TaskAssignment::class, 'task_assignment_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(VerificationComment::class, 'skip_request_id');
    }
}