<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\Student;
use App\Notifications\StudentCardsFailedNotification;
use App\Support\StudentCardFiles;
use App\Support\StudentCardPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateStudentCardsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600;

    public int $tries = 1;

    public function __construct(
        public int $count,
        public string $title,
        public string $academicYear,
        public string $classroom,
        public int $batch,
        public int $adminId,
    ) {}

    public function handle(): void
    {
        set_time_limit(0);

        $already = Student::where('batch', $this->batch)->count();
        $remaining = max(0, $this->count - $already);

        $nextId = (int) (Student::max('id') ?? 0) + 1;
        $plainPasswords = [];

        for ($i = 0; $i < $remaining; $i++) {
            $code = $this->classroom.'000-'.($nextId + $i).'-'.$this->academicYear;

            if (Student::where('code', $code)->exists()) {
                continue;
            }

            $plainPassword = StudentCardPassword::generate();

            $student = Student::create([
                'title' => $this->title,
                'code' => $code,
                'batch' => $this->batch,
                'academic_year' => $this->academicYear,
                'classroom' => $this->classroom,
                'password' => $plainPassword,
                'created_by' => $this->adminId,
            ]);

            $plainPasswords[$student->id] = $plainPassword;
        }

        $total = Student::where('batch', $this->batch)->count();
        $admin = Admin::find($this->adminId);

        if ($total < 1) {
            $admin?->notify(new StudentCardsFailedNotification(
                $this->batch,
                'لم يتم إنشاء أي كارت.'
            ));

            return;
        }

        (new GenerateStudentCardsJob($this->batch, $this->adminId, $plainPasswords))->handle(
            app(StudentCardFiles::class)
        );
    }
}
