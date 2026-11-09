<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DokumenWajib extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pengawas_id',
        'triwulan',
        'nama_dokumen',
        'instruksi',
        'is_wajib',
        'berlaku_untuk',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_wajib' => 'boolean',
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const BERLAKU_UNTUK = [
        'SEMUA'  => 'Semua Guru',
        'KEPSEK' => 'Guru merangkap Kepsek saja',
    ];

    const TRIWULAN_CHOICES = [
        1 => 'TW I',
        2 => 'TW II',
        3 => 'TW III',
        4 => 'TW IV',
    ];

    public function pengawas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengawas_id');
    }

    public function uploadDokumen(): HasMany
    {
        return $this->hasMany(UploadDokumen::class);
    }

    /**
     * TAMBAHAN BARU: Filter dokumen wajib di halaman Admin/Pengawas
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        if ($user->isAdmin()) {
            return $query;
        }

        return $query->where('pengawas_id', $user->id);
    }

    /**
     * TAMBAHAN BARU: Filter dokumen wajib untuk Guru Binaan sesuai pengawas pembimbingnya
     */
    public function scopeForGuru(Builder $query, GuruBinaan $guru): Builder
    {
        return $query->where(function (Builder $q) use ($guru) {
            $q->where('pengawas_id', $guru->pengawas_id)
              ->orWhereNull('pengawas_id');
        });
    }
}
