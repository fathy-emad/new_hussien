<?php

namespace App\Support;

use App\Models\Capacitor;
use App\Models\CapacitorCard;
use App\Models\CapacitorCardLessonView;

class CapacitorOfflineAccess
{
    public static function viewCount(CapacitorCard $card, Capacitor $lesson): int
    {
        return (int) CapacitorCardLessonView::query()
            ->where('capacitor_card_id', $card->id)
            ->where('capacitor_id', $lesson->id)
            ->value('view_count');
    }

    public static function maxViews(Capacitor $lesson): int
    {
        return max(1, (int) ($lesson->watch_times ?: 1));
    }

    public static function remainingViews(CapacitorCard $card, Capacitor $lesson): int
    {
        return max(0, self::maxViews($lesson) - self::viewCount($card, $lesson));
    }

    public static function canWatch(CapacitorCard $card, Capacitor $lesson): bool
    {
        return self::viewCount($card, $lesson) < self::maxViews($lesson);
    }

    public static function recordView(CapacitorCard $card, Capacitor $lesson): void
    {
        $row = CapacitorCardLessonView::firstOrCreate(
            [
                'capacitor_card_id' => $card->id,
                'capacitor_id' => $lesson->id,
            ],
            ['view_count' => 0]
        );

        $row->increment('view_count');

        if (! $card->visited) {
            $card->forceFill(['visited' => now()])->save();
        }
    }
}
