<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatriksPrioritas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guru_id',
        'periode_id',
        'kategori_prioritas',
        'skor_kelengkapan',
        'skor_respons',
        'skor_total',
        'catatan_admin',
    ];

    protected $casts = [
        'skor_kelengkapan' => 'decimal:2',
        'skor_respons' => 'decimal:2',
        'skor_total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const KATEGORI_PRIORITAS_UTAMA    = 'prioritas_utama';
    const KATEGORI_PRIORITAS_MENENGAH = 'prioritas_menengah';
    const KATEGORI_PRIORITAS_AKHIR    = 'prioritas_akhir';

    public function guru(): BelongsTo
    {
        return $this->belongsTo(GuruBinaan::class, 'guru_id');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeTriwulan::class, 'periode_id');
    }
}