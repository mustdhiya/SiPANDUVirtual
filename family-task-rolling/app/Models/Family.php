<?php

namespace App\family;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Family extends Model
{
    use SoftDeletes;

    protected $table = 'families';

    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relasi ke family_members
    public function members(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'family_id');
    }

    // Relasi ke user yang membuat family
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke daily_reports (per family)
    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class, 'family_id');
    }
}