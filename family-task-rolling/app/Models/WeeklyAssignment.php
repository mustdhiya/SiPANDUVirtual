<?php

namespace App\scheduling;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyAssignment extends Model
{
    use SoftDeletes;

    protected $table = 'weekly_assignments';

    protected $fillable = [
        'rolling_schedule_id',
        'week_start_date',
        'week_end_date',
        'assignment_map', // JSON: task -> child mapping
        'is_locked',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'assignment_map' => 'array',
        'is_locked' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function rollingSchedule(): BelongsTo
    {
        return $this->belongsTo(RollingSchedule::class, 'rolling_schedule_id');
    }
}