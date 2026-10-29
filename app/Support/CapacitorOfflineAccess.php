<?php

namespace App\Support;

use App\Models\Capacitor;
use App\Models\CapacitorCard;
use App\Models\CapacitorCardLessonView;
use Illuminate\Support\Facades\DB;

class CapacitorOfflineAccess
{
    /** Collapse duplicate HTTP hits of the same visit (Chrome prefetch / double GET). */
    private const DUPLICATE_HIT_SECONDS = 2;

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
        DB::transaction(function () use ($card, $lesson) {
            $row = CapacitorCardLessonView::query()
                ->where('capacitor_card_id', $card->id)
                ->where('capacitor_id', $lesson->id)
                ->lockForUpdate()
                ->first();

            if ($row && $row->updated_at && $row->updated_at->gte(now()->subSeconds(self::DUPLICATE_HIT_SECONDS))) {
                return;
            }

            if (! $row) {
                CapacitorCardLessonView::create([
                    'capacitor_card_id' => $card->id,
                    'capacitor_id' => $lesson->id,
                    'view_count' => 1,
                ]);
            } else {
                $row->view_count = (int) $row->view_count + 1;
                $row->save();
            }

            if (! $card->visited) {
                $card->forceFill(['visited' => now()])->save();
            }
        });
    }
}
