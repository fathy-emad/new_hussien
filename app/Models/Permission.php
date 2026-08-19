<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    protected $fillable = [
        'title',
        'permissions',
        'created_by',
        'updated_by'
    ];

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }
}
