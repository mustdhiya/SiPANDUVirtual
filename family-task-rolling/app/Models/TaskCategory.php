<?php

namespace App\tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskCategory extends Model
{
    use SoftDeletes;

    protected $table = 'task_categories';

    protected $fillable = [
        'name',
        'description',
        'family_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function templates(): HasMany
    {
        return $this->hasMany(TaskTemplate::class, 'category_id');
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }
}