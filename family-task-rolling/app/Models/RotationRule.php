<?php

namespace App\scheduling;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RotationRule extends Model
{
    use SoftDeletes;

    protected $table = 'rotation_rules';

    protected $fillable = [
        'rolling_schedule_id',
        'task_template_id',
        'rotation_order', // integer, urutan rotasi
        'interval_days',  // misal 1 = setiap hari, 7 = setiap minggu
        'is_active',
    ];

    protected $casts = [
        'rotation_order' => 'integer',
        'interval_days' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function rollingSchedule(): BelongsTo
    {
        return $this->belongsTo(RollingSchedule::class, 'rolling_schedule_id');
    }

    public function taskTemplate()
    {
        return $this->belongsTo(TaskTemplate::class, 'task_template_id');
    }
}