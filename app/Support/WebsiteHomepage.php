<?php

namespace App\Support;

use App\Models\Capacitor;
use App\Models\Center;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\WebsitePageSection;
use App\Models\WebsiteReview;
use Illuminate\Support\Collection;

class WebsiteHomepage
{
    public static function data(): array
    {
        $sections = WebsitePageSection::query()
            ->where('is_active', true)
            ->get()
            ->keyBy('section_key');

        $classRooms = getConstant('classRooms')->getArray();

        return [
            'sections' => $sections,
            'stats' => self::stats(),
            'offlineLessons' => self::offlineLessons(),
            'offlineLessonsByClassroom' => self::offlineLessonsByClassroom($classRooms),
            'centers' => Center::query()->orderBy('title')->get(),
            'reviews' => self::approvedReviews($classRooms),
            'classRooms' => $classRooms,
        ];
    }

    public static function section(Collection $sections, string $key): ?WebsitePageSection
    {
        return $sections->get($key);
    }

    public static function stats(): array
    {
        return [
            'students' => Student::query()->count(),
            'centers' => Center::query()->count(),
            'offline' => Capacitor::query()->where('active', true)->count(),
            'lessons' => Lesson::query()->count(),
        ];
    }

    public static function offlineLessons(): Collection
    {
        return Capacitor::query()
            ->where('active', true)
            ->orderByDesc('id')
            ->get();
    }

    public static function offlineLessonsByClassroom(array $classRooms): array
    {
        $lessons = self::offlineLessons();
        $grouped = [];

        foreach ($classRooms as $key => $label) {
            $grouped[$key] = [
                'label' => $label,
                'lessons' => $lessons
                    ->filter(fn (Capacitor $lesson) => (string) $lesson->classroom === (string) $key)
                    ->values(),
            ];
        }

        return $grouped;
    }

    public static function siteLogo(): string
    {
        return asset('/build/img/logo/master-hussien-logo.png');
    }

    public static function siteIcon(): string
    {
        return asset('/build/img/logo/master-hussien-icon.png');
    }

    public static function offlineLessonLogo(): string
    {
        return self::siteIcon();
    }

    public static function approvedReviews(array $classRooms): Collection
    {
        return WebsiteReview::query()
            ->with('student.center')
            ->where('is_approved', true)
            ->orderByDesc('approved_at')
            ->orderByDesc('id')
            ->get()
            ->map(function (WebsiteReview $review) use ($classRooms) {
                $student = $review->student;
                $classroomKey = (int) ($student?->classroom ?? 0);

                return [
                    'body' => $review->body,
                    'name' => $student?->name ?: ($student?->code ?? 'طالب'),
                    'avatar' => self::studentAvatarUrl($student?->avatar),
                    'classroom' => $classRooms[$classroomKey] ?? ($student?->classroom ?? '—'),
                    'year' => $student?->academic_year ?? '—',
                ];
            });
    }

    public static function capacitorImage(Capacitor $capacitor): string
    {
        $candidates = [];

        $thumbnail = normalizeStoredFilename($capacitor->thumbnail);
        if ($thumbnail) {
            $candidates[] = $thumbnail;
        }

        foreach (array_filter(explode(',', (string) $capacitor->images)) as $image) {
            $candidates[] = trim($image);
        }

        foreach ($candidates as $file) {
            if ($file === '') {
                continue;
            }

            $path = public_path("uploads/capacitors/lessons/images/{$file}");
            if (is_file($path)) {
                return asset("uploads/capacitors/lessons/images/{$file}");
            }
        }

        return asset('/build/img/course/course-07.jpg');
    }

    public static function sectionImage(?string $filename): ?string
    {
        $file = normalizeStoredFilename($filename);
        if (! $file) {
            return null;
        }

        $path = public_path("uploads/website/images/{$file}");
        if (! is_file($path)) {
            return null;
        }

        return asset("uploads/website/images/{$file}");
    }

    public static function studentAvatarUrl(?string $avatar): string
    {
        $file = normalizeStoredFilename($avatar);
        if ($file && is_file(public_path("uploads/students/images/{$file}"))) {
            return asset("uploads/students/images/{$file}");
        }

        return asset('/build/img/user/user-17.jpg');
    }
}
