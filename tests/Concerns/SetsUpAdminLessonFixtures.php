<?php

namespace Tests\Concerns;

use App\Models\Admin;
use App\Models\Chapter;
use Illuminate\Support\Facades\Hash;

trait SetsUpAdminLessonFixtures
{
    protected Admin $admin;

    protected Chapter $chapter;

    protected function setUpAdminLessonFixtures(): void
    {
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
