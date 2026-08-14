<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DokumenWajib extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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

    public function uploadDokumen(): HasMany
    {
        return $this->hasMany(UploadDokumen::class);
    }
}