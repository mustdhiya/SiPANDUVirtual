<?php

namespace App\verification;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class EvidencePhoto extends Model
{
    use SoftDeletes;

    protected $table = 'evidence_photos';

    protected $fillable = [
        'verification_id',
        'uploaded_by',
        'file_path',
        'file_name',
        'mime_type',
        'size_bytes',
        'note',
    ];

    protected $casts = [
        'size_bytes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function verification(): BelongsTo
    {
        return $this->belongsTo(TaskVerification::class, 'verification_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}