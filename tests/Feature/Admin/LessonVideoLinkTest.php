<?php

namespace Tests\Feature\Admin;

use App\Models\Lesson;
use App\Support\VideoStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\SetsUpAdminLessonFixtures;
use Tests\TestCase;

class LessonVideoLinkTest extends TestCase
{
    use RefreshDatabase;
    use SetsUpAdminLessonFixtures;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpAdminLessonFixtures();
    }

    public function test_create_saves_link_when_video_exists_on_storage_and_is_submitted(): void
    {
        $fileName = $this->putLessonVideoOnStorage('1710000001_testvideo.mp4');

        $response = $this->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
            'link' => $fileName,
        ]));

        $response->assertRedirect(route('admin.settings.lesson.index', [
            'chapter_id' => $this->chapter->id,
            'classroom' => $this->chapter->classroom,
        ]));

        $this->assertDatabaseHas('lessons', [
            'title' => 'Test Lesson',
            'chapter_id' => $this->chapter->id,
            'link' => $fileName,
        ]);
    }

    public function test_create_does_not_save_link_when_video_on_storage_but_not_submitted(): void
    {
        $fileName = $this->putLessonVideoOnStorage('1710000002_orphan.mp4');

        $response = $this->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
            'link' => '',
        ]));

        $response->assertRedirect();

        $lesson = Lesson::where('title', 'Test Lesson')->first();

        $this->assertNotNull($lesson);
        $this->assertTrue($lesson->link === null || $lesson->link === '');
        $this->assertTrue(Storage::disk('videos')->exists(
            VideoStorage::relativePath(VideoStorage::FOLDER_LESSONS, $fileName)
        ));
    }

    public function test_create_rejects_submitted_link_when_file_missing_on_storage(): void
    {
        $response = $this->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
            'link' => 'missing_video.mp4',
        ]));

        $response->assertSessionHasErrors('link');
        $this->assertDatabaseMissing('lessons', ['title' => 'Test Lesson']);
    }

    public function test_create_saves_server_filename_from_session_when_client_name_submitted(): void
    {
        $serverFile = $this->putLessonVideoOnStorage('1780815717_shccLchg1y.mp4');

        $response = $this->withSession(['admin_pending_lesson_video' => $serverFile])
            ->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
                'link' => 'setbmp4.mp4',
            ]));

        $response->assertRedirect();

        $this->assertDatabaseHas('lessons', [
            'title' => 'Test Lesson',
            'chapter_id' => $this->chapter->id,
            'link' => $serverFile,
        ]);
    }

    public function test_update_saves_link_when_video_exists_on_storage_and_is_submitted(): void
    {
        $lesson = Lesson::create([
            'title' => 'Existing Lesson',
            'chapter_id' => $this->chapter->id,
            'link' => '',
            'NO' => 2,
            'watchTimes' => 1,
            'created_by' => $this->admin->id,
        ]);

        $fileName = $this->putLessonVideoOnStorage('1710000003_update.mp4');

        $response = $this->post(route('admin.settings.lesson.update', $lesson->id), $this->lessonPayload([
            'title' => 'Existing Lesson',
            'NO' => 2,
            'link' => $fileName,
        ]));

        $response->assertRedirect();

        $this->assertDatabaseHas('lessons', [
            'id' => $lesson->id,
            'link' => $fileName,
        ]);
    }

    public function test_update_does_not_save_orphan_storage_file_without_link_submitted(): void
    {
        $lesson = Lesson::create([
            'title' => 'Lesson Without Video',
            'chapter_id' => $this->chapter->id,
            'link' => '',
            'NO' => 3,
            'watchTimes' => 1,
            'created_by' => $this->admin->id,
        ]);

        $orphanFile = $this->putLessonVideoOnStorage('1710000004_orphan_update.mp4');

        $response = $this->post(route('admin.settings.lesson.update', $lesson->id), $this->lessonPayload([
            'title' => 'Lesson Without Video',
            'NO' => 3,
            'link' => '',
        ]));

        $response->assertRedirect();

        $lesson->refresh();

        $this->assertTrue($lesson->link === null || $lesson->link === '');
        $this->assertTrue(Storage::disk('videos')->exists(
            VideoStorage::relativePath(VideoStorage::FOLDER_LESSONS, $orphanFile)
        ));
    }

    public function test_update_rejects_submitted_link_when_file_missing_on_storage(): void
    {
        $lesson = Lesson::create([
            'title' => 'Lesson To Update',
            'chapter_id' => $this->chapter->id,
            'link' => '',
            'NO' => 4,
            'watchTimes' => 1,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->post(route('admin.settings.lesson.update', $lesson->id), $this->lessonPayload([
            'title' => 'Lesson To Update',
            'NO' => 4,
            'link' => 'ghost_file.mp4',
        ]));

        $response->assertSessionHasErrors('link');

        $this->assertDatabaseHas('lessons', [
            'id' => $lesson->id,
            'link' => '',
        ]);
    }

    public function test_update_replaces_link_when_new_video_submitted(): void
    {
        $oldFile = $this->putLessonVideoOnStorage('1710000005_old.mp4');
        $newFile = $this->putLessonVideoOnStorage('1710000006_new.mp4');

        $lesson = Lesson::create([
            'title' => 'Lesson With Video',
            'chapter_id' => $this->chapter->id,
            'link' => $oldFile,
            'NO' => 5,
            'watchTimes' => 1,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->post(route('admin.settings.lesson.update', $lesson->id), $this->lessonPayload([
            'title' => 'Lesson With Video',
            'NO' => 5,
            'link' => $newFile,
        ]));

        $response->assertRedirect();

        $this->assertDatabaseHas('lessons', [
            'id' => $lesson->id,
            'link' => $newFile,
        ]);

        $this->assertFalse(Storage::disk('videos')->exists(
            VideoStorage::relativePath(VideoStorage::FOLDER_LESSONS, $oldFile)
        ));
    }
}
