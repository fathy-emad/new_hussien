<?php

namespace Tests\Concerns;

use App\Models\Admin;
use App\Models\Chapter;
use App\Support\VideoStorage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

trait SetsUpAdminLessonFixtures
{
    protected Admin $admin;

    protected Chapter $chapter;

    protected function setUpAdminLessonFixtures(): void
    {
        Storage::fake('videos');

        $this->admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin-lesson-test@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->chapter = Chapter::create([
            'title' => 'Test Chapter',
            'classroom' => '1',
            'academic_year' => 2025,
            'chapterNo' => '1',
            'created_by' => $this->admin->id,
        ]);

        $this->actingAs($this->admin, 'admin');
    }

    protected function putLessonVideoOnStorage(string $fileName, string $content = 'fake-video-binary'): string
    {
        $path = VideoStorage::relativePath(VideoStorage::FOLDER_LESSONS, $fileName);
        Storage::disk('videos')->put($path, $content);

        return $fileName;
    }

    protected function lessonPayload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Test Lesson',
            'chapter_id' => $this->chapter->id,
            'NO' => 1,
            'watchTimes' => 3,
            'info' => 'Lesson description',
            'link' => '',
            'images' => [],
            'pdf' => [],
        ], $overrides);
    }
}
