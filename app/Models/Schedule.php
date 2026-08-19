<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'academic_year',
        'classroom',
        'center_id',
        'day',
        'from',
        'to',
        'canceled',
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

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id', 'id');
    }

    public function counts(): HasMany
    {
        return $this->hasMany(ScheduleCount::class, 'schedule_id', 'id');
    }
}
