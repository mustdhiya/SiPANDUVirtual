<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
}