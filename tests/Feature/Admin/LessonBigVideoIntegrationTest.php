<?php

namespace Tests\Feature\Admin;

use App\Models\Lesson;
use App\Support\VideoStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\SetsUpAdminLessonFixtures;
use Tests\Concerns\SimulatesChunkedLessonVideoUpload;
use Tests\TestCase;

/**
 * End-to-end: chunked video upload (300MB metadata) → create/update lesson → MySQL link column.
 */
class LessonBigVideoIntegrationTest extends TestCase
{
    use RefreshDatabase;
    use SetsUpAdminLessonFixtures;
    use SimulatesChunkedLessonVideoUpload;

    private const SIMULATED_300MB = 314572800;

    private const CHUNKS_FOR_300MB = 150;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpAdminLessonFixtures();
    }

    protected function tearDown(): void
    {
        $chunksBase = storage_path('app/'.config('upload.chunks_path'));
        if (is_dir($chunksBase)) {
            File::deleteDirectory($chunksBase);
        }

        parent::tearDown();
    }

    public function test_chunked_300mb_upload_then_create_saves_link_to_mysql(): void
    {
        $upload = $this->uploadLessonVideoViaChunks(
            declaredTotalBytes: self::SIMULATED_300MB,
            totalChunks: self::CHUNKS_FOR_300MB,
        );

        $response = $this->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
            'title' => 'Big Video Lesson Create',
            'link' => $upload['fileName'],
        ]));

        $response->assertRedirect(route('admin.settings.lesson.index', [
            'chapter_id' => $this->chapter->id,
            'classroom' => $this->chapter->classroom,
        ]));

        $this->assertDatabaseHas('lessons', [
            'title' => 'Big Video Lesson Create',
            'chapter_id' => $this->chapter->id,
            'link' => $upload['fileName'],
        ]);

        $lesson = Lesson::where('title', 'Big Video Lesson Create')->first();
        $this->assertNotNull($lesson);
        $this->assertSame($upload['fileName'], $lesson->link);
        $this->assertTrue(VideoStorage::exists(VideoStorage::FOLDER_LESSONS, $lesson->link));
    }

    public function test_chunked_300mb_upload_without_link_on_create_leaves_mysql_empty(): void
    {
        $upload = $this->uploadLessonVideoViaChunks(
            declaredTotalBytes: self::SIMULATED_300MB,
            totalChunks: self::CHUNKS_FOR_300MB,
        );

        $response = $this->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
            'title' => 'Orphan Big Video Lesson',
            'link' => '',
        ]));

        $response->assertRedirect();

        $lesson = Lesson::where('title', 'Orphan Big Video Lesson')->first();
        $this->assertNotNull($lesson);
        $this->assertTrue($lesson->link === null || $lesson->link === '');

        $this->assertTrue(Storage::disk('videos')->exists(
            VideoStorage::relativePath(VideoStorage::FOLDER_LESSONS, $upload['fileName'])
        ));
    }

    public function test_chunked_300mb_upload_then_update_saves_link_to_mysql(): void
    {
        $lesson = Lesson::create([
            'title' => 'Lesson For Big Update',
            'chapter_id' => $this->chapter->id,
            'link' => '',
            'NO' => 10,
            'watchTimes' => 2,
            'watchIntervalTime' => 7,
            'created_by' => $this->admin->id,
        ]);

        $upload = $this->uploadLessonVideoViaChunks(
            declaredTotalBytes: self::SIMULATED_300MB,
            totalChunks: self::CHUNKS_FOR_300MB,
            originalName: 'updated_300mb.mp4',
        );

        $response = $this->post(route('admin.settings.lesson.update', $lesson->id), $this->lessonPayload([
            'title' => 'Lesson For Big Update',
            'NO' => 10,
            'link' => $upload['fileName'],
        ]));

        $response->assertRedirect();

        $this->assertDatabaseHas('lessons', [
            'id' => $lesson->id,
            'link' => $upload['fileName'],
        ]);

        $lesson->refresh();
        $this->assertSame($upload['fileName'], $lesson->link);
    }

    public function test_chunked_300mb_upload_then_update_replaces_existing_link(): void
    {
        $oldUpload = $this->uploadLessonVideoViaChunks(
            declaredTotalBytes: self::SIMULATED_300MB,
            totalChunks: 10,
            originalName: 'old_small_batch.mp4',
        );

        $lesson = Lesson::create([
            'title' => 'Lesson Replace Video',
            'chapter_id' => $this->chapter->id,
            'link' => $oldUpload['fileName'],
            'NO' => 11,
            'watchTimes' => 2,
            'watchIntervalTime' => 7,
            'created_by' => $this->admin->id,
        ]);

        $newUpload = $this->uploadLessonVideoViaChunks(
            declaredTotalBytes: self::SIMULATED_300MB,
            totalChunks: self::CHUNKS_FOR_300MB,
            originalName: 'new_300mb.mp4',
        );

        $response = $this->post(route('admin.settings.lesson.update', $lesson->id), $this->lessonPayload([
            'title' => 'Lesson Replace Video',
            'NO' => 11,
            'link' => $newUpload['fileName'],
        ]));

        $response->assertRedirect();

        $lesson->refresh();

        $this->assertSame($newUpload['fileName'], $lesson->link);
        $this->assertFalse(VideoStorage::exists(VideoStorage::FOLDER_LESSONS, $oldUpload['fileName']));
        $this->assertTrue(VideoStorage::exists(VideoStorage::FOLDER_LESSONS, $newUpload['fileName']));
    }

    public function test_create_rejects_chunked_filename_when_form_submits_before_merge_finishes(): void
    {
        $response = $this->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
            'title' => 'Ghost Video Lesson',
            'link' => 'not_uploaded_yet.mp4',
        ]));

        $response->assertSessionHasErrors('link');
        $this->assertDatabaseMissing('lessons', ['title' => 'Ghost Video Lesson']);
    }
}
