<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StudentCardsReadyNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $batch,
        public int $generated,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'kind' => 'cards_ready',
            'title' => 'الكروت جاهزة للتحميل',
            'message' => "تم توليد ({$this->generated}) كارت لـ Batch #{$this->batch}. يمكنك تحميل الملف الآن.",
            'url' => route('admin.students.studentCards.download', $this->batch),
            'batch' => $this->batch,
        ];
    }
}
