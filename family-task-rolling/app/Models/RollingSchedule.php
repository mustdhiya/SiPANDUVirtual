<?php

namespace App\scheduling;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RollingSchedule extends Model
{
    use SoftDeletes;

    protected $table = 'rolling_schedules';

    protected $fillable = [
        'family_id',
        'name',
        'type', // daily, weekly, custom
        'start_date',
        'end_date',
        'is_active',
        'config', // JSON
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'config' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    public function rotationRules(): HasMany
    {
        return $this->hasMany(RotationRule::class, 'rolling_schedule_id');
    }

    public function weeklyAssignments(): HasMany
    {
        return $this->hasMany(WeeklyAssignment::class, 'rolling_schedule_id');
    }
}