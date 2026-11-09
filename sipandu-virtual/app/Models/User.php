<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'nama_tanpa_gelar',
        'email',
        'password',
        'password_plain',
        'role',
        'is_approved',
        'status',
        'is_profile_complete',
        'nomor_wa',
        'nip',
        'pangkat_golongan',
        'jabatan_pengawas',
        'unit_kerja',
        'kabupaten_kota',
        'provinsi',
        'wilayah_binaan',
        'alias_julukan',
        'riwayat_singkat',
        'foto_profil',
        'ttd_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at'   => 'datetime',
        'is_approved'         => 'boolean',
        'is_profile_complete' => 'boolean',
    ];

    const ROLE_ADMIN    = 'admin';    // Admin Utama sekaligus Pengawas (Mama)
    const ROLE_PENGAWAS = 'pengawas'; // Rekan Pengawas
    const ROLE_GURU     = 'guru';     // Guru Binaan

    const STATUS_PENDING   = 'pending';
    const STATUS_ACTIVE    = 'active';
    const STATUS_SUSPENDED = 'suspended';

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPengawas(): bool
    {
        return $this->role === self::ROLE_PENGAWAS;
    }

    public function isPanelPengawas(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_PENGAWAS], true);
    }

    public function isGuru(): bool
    {
        return $this->role === self::ROLE_GURU;
    }

    public function canLogin(): bool
    {
        return $this->is_approved && $this->status === self::STATUS_ACTIVE;
    }

    public function guruBinaan(): HasMany
    {
        return $this->hasMany(GuruBinaan::class, 'pengawas_id');
    }

    public function profilGuru(): HasOne
    {
        return $this->hasOne(GuruBinaan::class, 'user_account_id');
    }

    public function dokumenWajib(): HasMany
    {
        return $this->hasMany(DokumenWajib::class, 'pengawas_id');
    }
}