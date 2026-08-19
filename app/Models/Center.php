<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Center extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "address",
        "phone",
        'created_by',
        'updated_by'
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'center_id', 'id');
    }
}
