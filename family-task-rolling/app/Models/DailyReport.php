<?php

namespace App\reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailyReport extends Model
{
    use SoftDeletes;

    protected $table = 'daily_reports';

    protected $fillable = [
        'family_id',
        'user_id',
        'report_date',
        'total_tasks',
        'completed_tasks',
        'pending_tasks',
        'absent_tasks',
        'skipped_tasks',
        'discipline_score',
        'note',
    ];

    protected $casts = [
        'report_date' => 'date',
        'total_tasks' => 'integer',
        'completed_tasks' => 'integer',
        'pending_tasks' => 'integer',
        'absent_tasks' => 'integer',
        'skipped_tasks' => 'integer',
        'discipline_score' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attendanceScores(): HasMany
    {
        return $this->hasMany(AttendanceScore::class, 'daily_report_id');
    }
}