<?php

namespace App\tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'task_templates';

    protected $fillable = [
        'category_id',
        'family_id',
        'title',
        'description',
        'estimated_duration_minutes',
        'difficulty_level', // easy, medium, hard
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(TaskCategory::class, 'category_id');
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    public function dailyTasks(): HasMany
    {
        return $this->hasMany(DailyTask::class, 'template_id');
    }
}