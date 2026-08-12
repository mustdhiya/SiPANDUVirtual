<?php

namespace App\verification;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class VerificationComment extends Model
{
    use SoftDeletes;

    protected $table = 'verification_comments';

    protected $fillable = [
        'verification_id',
        'skip_request_id',
        'commented_by',
        'content',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function verification(): BelongsTo
    {
        return $this->belongsTo(TaskVerification::class, 'verification_id');
    }

    public function skipRequest(): BelongsTo
    {
        return $this->belongsTo(SkipRequest::class, 'skip_request_id');
    }

    public function commenter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'commented_by');
    }
}