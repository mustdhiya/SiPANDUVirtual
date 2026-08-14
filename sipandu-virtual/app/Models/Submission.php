<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guru_id',
        'periode_id',
        'status_review',
        'feedback_admin',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const STATUS_DRAFT     = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_REVISI    = 'revisi';
    const STATUS_LENGKAP   = 'lengkap';

    public function guru(): BelongsTo
    {
        return $this->belongsTo(GuruBinaan::class, 'guru_id');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeTriwulan::class, 'periode_id');
    }

    public function uploadDokumen(): HasMany
    {
        return $this->hasMany(UploadDokumen::class);
    }
}