<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'notificationTime',
        'count',
    ];

    public $timestamps = false;

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }
}
