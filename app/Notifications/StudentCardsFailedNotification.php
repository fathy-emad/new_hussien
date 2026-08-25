<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StudentCardsFailedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $batch,
        public string $reason,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'kind' => 'cards_failed',
            'title' => 'فشل تجهيز كروت الطلاب',
            'message' => "Batch #{$this->batch}: {$this->reason}",
            'url' => route('admin.students.studentCards.index'),
            'batch' => $this->batch,
        ];
    }
}
