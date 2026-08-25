<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\Student;
use App\Notifications\StudentCardsFailedNotification;
use App\Notifications\StudentCardsReadyNotification;
use App\Support\StudentCardFiles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class GenerateStudentCardsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 7200;

    public int $tries = 1;

    public function __construct(
        public int|string $batch,
        public int $adminId,
        public array $plainPasswords = [],
    ) {}

    public function handle(StudentCardFiles $files): void
    {
        set_time_limit(0);

        $admin = Admin::find($this->adminId);
        $batch = (string) $this->batch;

        if (! class_exists('\DNS1D')) {
            $admin?->notify(new StudentCardsFailedNotification($this->batch, 'حزمة milon/barcode غير مثبتة.'));

            return;
        }

        if (! class_exists(\Intervention\Image\ImageManager::class)) {
            $admin?->notify(new StudentCardsFailedNotification($this->batch, 'حزمة intervention/image غير مثبتة.'));

            return;
        }

        if (! Student::where('batch', $this->batch)->exists()) {
            $admin?->notify(new StudentCardsFailedNotification($this->batch, "لا يوجد كروت في Batch {$batch}."));

            return;
        }

        $template = public_path('assets/images/back-card.jpeg');
        if (! is_file($template)) {
            $admin?->notify(new StudentCardsFailedNotification($this->batch, "قالب الكارت غير موجود: {$template}"));

            return;
        }

        File::ensureDirectoryExists(public_path('cards'));
        $files->purgeOldBatchFiles($this->batch);

        $stamp = now()->format('Ymd_His');
        $cardsDir = storage_path("app/tmp/cards/batch_{$batch}_{$stamp}");
        $zipName = "batch_{$batch}_{$stamp}.zip";
        $publicZip = public_path("cards/{$zipName}");

        File::ensureDirectoryExists($cardsDir);

        $fontPath = public_path('fonts/Inter-Bold.ttf');
        if (! is_file($fontPath)) {
            $fontPath = null;
        }

        $generated = 0;
        Student::where('batch', $this->batch)
            ->select('id')
            ->orderBy('id')
            ->chunkById(500, function ($chunk) use ($template, $cardsDir, $fontPath, &$generated) {
                foreach ($chunk as $row) {
                    (new MakeCard(
                        $row->id,
                        $template,
                        $cardsDir,
                        $fontPath,
                        $this->plainPasswords[$row->id] ?? null
                    ))->handle();
                    $generated++;
                }
            });

        if ($generated === 0) {
            $admin?->notify(new StudentCardsFailedNotification($this->batch, "لا يوجد كروت في Batch {$batch}."));

            return;
        }

        (new ZipCards($cardsDir, $publicZip))->handle();

        if (! is_file($publicZip)) {
            $admin?->notify(new StudentCardsFailedNotification($this->batch, 'فشل إنشاء ملف التحميل.'));

            return;
        }

        $admin?->notify(new StudentCardsReadyNotification((int) $this->batch, $generated));
    }
}
