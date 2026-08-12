<?php

namespace App\reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceScore extends Model
{
    use SoftDeletes;

    protected $table = 'attendance_scores';

    protected $fillable = [
        'daily_report_id',
        'user_id',
        'attendance_rate',
        'on_time_count',
        'late_count',
        'absent_count',
    ];

    protected $casts = [
        'attendance_rate' => 'decimal:2',
        'on_time_count' => 'integer',
        'late_count' => 'integer',
        'absent_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function dailyReport(): BelongsTo
    {
        return $this->belongsTo(DailyReport::class, 'daily_report_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}