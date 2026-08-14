<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SekolahBinaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_sekolah',
        'jenjang',
        'status',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const JENJANG_CHOICES = [
        'SMA' => 'SMA',
        'SMK' => 'SMK',
    ];

    const STATUS_CHOICES = [
        'N' => 'Negeri',
        'S' => 'Swasta',
    ];

    public function guruBinaan(): HasMany
    {
        return $this->hasMany(GuruBinaan::class);
    }
}