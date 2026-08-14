<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UploadDokumen extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'submission_id',
        'dokumen_wajib_id',
        'file',
        'catatan',
        'status',
        'feedback_admin',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const STATUS_PENDING   = 'pending';
    const STATUS_DITERIMA  = 'diterima';
    const STATUS_REVISI    = 'revisi';

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function dokumenWajib(): BelongsTo
    {
        return $this->belongsTo(DokumenWajib::class);
    }
}