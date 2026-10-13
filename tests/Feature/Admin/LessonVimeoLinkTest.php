<?php

namespace Tests\Feature\Admin;

use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\SetsUpAdminLessonFixtures;
use Tests\TestCase;

class LessonVimeoLinkTest extends TestCase
{
    use RefreshDatabase;
    use SetsUpAdminLessonFixtures;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpAdminLessonFixtures();
    }

    public function test_create_saves_normalized_vimeo_id(): void
    {
        $response = $this->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
            'link' => 'https://vimeo.com/123456789',
        ]));

        $response->assertRedirect(route('admin.settings.lesson.index', [
            'chapter_id' => $this->chapter->id,
            'classroom' => $this->chapter->classroom,
        ]));

        $this->assertDatabaseHas('lessons', [
            'title' => 'Test Lesson',
            'link' => '123456789',
        ]);
    }

    public function test_create_rejects_non_vimeo_link(): void
    {
        $response = $this->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
            'link' => 'hosted.mp4',
        ]));

        $response->assertSessionHasErrors('link');
        $this->assertDatabaseMissing('lessons', ['title' => 'Test Lesson']);
    }

    public function test_update_saves_vimeo_id_with_hash(): void
    {
        $lesson = Lesson::create([
            'title' => 'Existing Lesson',
            'chapter_id' => $this->chapter->id,
            'link' => '',
            'NO' => 2,
            'watchTimes' => 1,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->post(route('admin.settings.lesson.update', $lesson->id), $this->lessonPayload([
            'title' => 'Existing Lesson',
            'NO' => 2,
            'link' => 'https://player.vimeo.com/video/987654321?h=privhash',
        ]));

        $response->assertRedirect();
        $this->assertDatabaseHas('lessons', [
            'id' => $lesson->id,
            'link' => '987654321:privhash',
        ]);
    }
}
