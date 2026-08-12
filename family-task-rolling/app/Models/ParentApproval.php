<?php

namespace App\family;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class ParentApproval extends Model
{
    use SoftDeletes;

    protected $table = 'parent_approvals';

    protected $fillable = [
        'family_id',
        'parent_id',
        'action_type', // 'skip_request', 'task_override', 'rolling_override'
        'action_data', // JSON
        'status',      // 'pending', 'approved', 'rejected'
        'note',
    ];

    protected $casts = [
        'action_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}