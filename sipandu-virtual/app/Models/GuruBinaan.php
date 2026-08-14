<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GuruBinaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_lengkap',
        'sekolah_id',
        'nip_siaga',
        'status_jabatan',
        'is_active',
        'user_account_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const STATUS_JABATAN = [
        'GURU'        => 'Guru PAI',
        'GURU_KEPSEK' => 'Guru PAI merangkap Kepala Sekolah',
    ];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(SekolahBinaan::class, 'sekolah_id');
    }

    public function userAccount(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_account_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'guru_id');
    }
}