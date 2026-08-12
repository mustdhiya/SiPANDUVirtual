<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    const ROLE_PARENT = 'parent';
    const ROLE_CHILD  = 'child';

    public function isParent(): bool
    {
        return $this->role === self::ROLE_PARENT;
    }

    public function isChild(): bool
    {
        return $this->role === self::ROLE_CHILD;
    }

    // Relasi ke family_members
    public function familyMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'user_id');
    }

    // Relasi ke task_assignments (sebagai child)
    public function taskAssignments(): HasMany
    {
        return $this->hasMany(TaskAssignment::class, 'assigned_to');
    }

    // Relasi ke task_history
    public function taskHistories(): HasMany
    {
        return $this->hasMany(TaskHistory::class, 'actor_id');
    }

    // Relasi ke skip requests (sebagai child yang request)
    public function skipRequests(): HasMany
    {
        return $this->hasMany(SkipRequest::class, 'requested_by');
    }

    // Relasi ke verifications (sebagai parent yang verifikasi)
    public function verifications(): HasMany
    {
        return $this->hasMany(TaskVerification::class, 'verified_by');
    }

    // Relasi ke daily_reports (jika perlu)
    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class, 'user_id');
    }

    // Relasi ke discipline_points
    public function disciplinePoints(): HasMany
    {
        return $this->hasMany(DisciplinePoint::class, 'user_id');
    }

    // Relasi ke attendance_scores
    public function attendanceScores(): HasMany
    {
        return $this->hasMany(AttendanceScore::class, 'user_id');
    }
}