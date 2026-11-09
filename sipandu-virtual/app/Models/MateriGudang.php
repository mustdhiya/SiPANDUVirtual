<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MateriGudang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori',
        'file',
        'uploaded_by',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const KATEGORI_MATERI = 'materi';
    const KATEGORI_INSTRUMEN_RISET = 'instrumen_riset';
    const KATEGORI_CONTOH_PERANGKAT = 'contoh_perangkat';

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * TAMBAHAN BARU: Filter materi untuk halaman Admin/Pengawas
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        if ($user->isAdmin()) {
            return $query;
        }

        return $query->where('uploaded_by', $user->id);
    }

    /**
     * TAMBAHAN BARU: Guru melihat materi dari pengawas pembimbingnya + materi umum dari Super Admin
     */
    public function scopeForGuru(Builder $query, GuruBinaan $guru): Builder
    {
        return $query->where(function (Builder $q) use ($guru) {
            $q->where('uploaded_by', $guru->pengawas_id)
              ->orWhereHas('uploader', function (Builder $u) {
                  $u->where('role', User::ROLE_ADMIN);
              });
        });
    }
}
