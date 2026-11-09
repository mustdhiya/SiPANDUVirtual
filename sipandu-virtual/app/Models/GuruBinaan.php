<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuruBinaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_lengkap',
        'sekolah_id',
        'pengawas_id',
        'nip_siaga',
        'status_jabatan',
        'sudah_sertifikasi',
        'is_active',
        'user_account_id',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'sudah_sertifikasi' => 'boolean',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'deleted_at'        => 'datetime',
    ];

    const STATUS_JABATAN = [
        'GURU'        => 'Guru PAI',
        'GURU_KEPSEK' => 'Guru PAI merangkap Kepala Sekolah',
    ];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(SekolahBinaan::class, 'sekolah_id');
    }

    public function pengawas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengawas_id');
    }

    public function userAccount(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_account_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'guru_id');
    }

    /**
     * TAMBAHAN BARU: Filter otomatis Guru Binaan sesuai pengawas yang login
     */
    public function scopeForUser(Builder $query, User $user, ?int $filterPengawasId = null): Builder
    {
        if ($user->isAdmin()) {
            return $filterPengawasId
                ? $query->where('pengawas_id', $filterPengawasId)
                : $query;
        }

        return $query->where('pengawas_id', $user->id);
    }
}