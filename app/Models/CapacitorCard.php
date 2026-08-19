<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CapacitorCard extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'batch',
        'code',
        'visited',
        'created_by',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
}
