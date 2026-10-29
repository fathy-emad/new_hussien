<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CapacitorCardLessonView extends Model
{
    protected $fillable = [
        'capacitor_card_id',
        'capacitor_id',
        'view_count',
        'last_session_id',
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(CapacitorCard::class, 'capacitor_card_id');
    }

    public function capacitor(): BelongsTo
    {
        return $this->belongsTo(Capacitor::class);
    }
}
