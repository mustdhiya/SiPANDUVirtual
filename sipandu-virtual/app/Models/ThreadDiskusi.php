<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThreadDiskusi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guru_id',
        'periode_id',
        'judul',
        'isi',
        'is_locked',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(GuruBinaan::class, 'guru_id');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeTriwulan::class, 'periode_id');
    }

    public function pesanDiskusi(): HasMany
    {
        return $this->hasMany(PesanDiskusi::class, 'thread_id');
    }

    /**
     * TAMBAHAN BARU: Filter diskusi khusus guru binaan milik pengawas yang login
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        if ($user->isAdmin()) {
            return $query;
        }

        return $query->whereHas('guru', function (Builder $q) use ($user) {
            $q->where('pengawas_id', $user->id);
        });
    }
}