<?php

namespace App\reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class DisciplinePoint extends Model
{
    use SoftDeletes;

    protected $table = 'discipline_points';

    protected $fillable = [
        'user_id',
        'family_id',
        'point_change',
        'reason_code', // task_completed, task_absent, task_skipped_excused, task_rejected, etc.
        'reason_detail',
        'reference_type', // task_assignment, daily_report, skip_request
        'reference_id',
    ];

    protected $casts = [
        'point_change' => 'integer',
        'reference_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }
}