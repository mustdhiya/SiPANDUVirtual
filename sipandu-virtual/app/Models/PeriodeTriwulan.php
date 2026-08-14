<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodeTriwulan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tahun_ajaran_id',
        'nomor',
        'tema',
        'deadline',
        'is_open',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'deadline' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const NOMOR_CHOICES = [
        1 => 'Triwulan I — Perencanaan & Pemetaan (Jan–Mar)',
        2 => 'Triwulan II — Pendampingan Tahap Awal (Apr–Jun)',
        3 => 'Triwulan III — Observasi & Umpan Balik (Jul–Sep)',
        4 => 'Triwulan IV — Evaluasi & Pelaporan (Okt–Des)',
    ];

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function isAccessible(): bool
    {
        return $this->is_open && now()->date() <= $this->deadline;
    }
}