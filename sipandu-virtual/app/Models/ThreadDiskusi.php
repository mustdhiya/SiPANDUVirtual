<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\GuruBinaan;
use App\Models\PeriodeTriwulan;
use App\Models\User;

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
        return $this->hasMany(PesanDiskusi::class);
    }
}