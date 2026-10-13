<?php

namespace Tests\Feature\Admin;

use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\SetsUpAdminLessonFixtures;
use Tests\TestCase;

class LessonPdfAttachmentsTest extends TestCase
{
    use RefreshDatabase;
    use SetsUpAdminLessonFixtures;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpAdminLessonFixtures();
        Storage::fake('uploads');
    }

    public function test_create_saves_comma_separated_pdfs_to_database(): void
    {
        $pdfOne = $this->putLessonPdfOnStorage('1710000101_first.pdf');
        $pdfTwo = $this->putLessonPdfOnStorage('1710000102_second.pdf');

        $response = $this->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
            'pdf' => [$pdfOne, $pdfTwo],
        ]));

        $response->assertRedirect();

        $this->assertDatabaseHas('lessons', [
            'title' => 'Test Lesson',
            'pdf' => $pdfOne.','.$pdfTwo,
        ]);
    }

    public function test_create_rejects_pdf_when_file_missing_on_storage(): void
    {
        $response = $this->post(route('admin.settings.lesson.create.submit'), $this->lessonPayload([
            'pdf' => ['ghost.pdf'],
        ]));

        $response->assertSessionHasErrors('pdf');
        $this->assertDatabaseMissing('lessons', ['title' => 'Test Lesson']);
    }

    public function test_update_replaces_pdf_csv_and_deletes_removed_file(): void
    {
        $oldPdf = $this->putLessonPdfOnStorage('1710000103_old.pdf');
        $keptPdf = $this->putLessonPdfOnStorage('1710000104_kept.pdf');
        $newPdf = $this->putLessonPdfOnStorage('1710000105_new.pdf');

        $lesson = Lesson::create([
            'title' => 'Lesson With PDFs',
            'chapter_id' => $this->chapter->id,
            'link' => '',
            'pdf' => $oldPdf.','.$keptPdf,
            'NO' => 6,
            'watchTimes' => 1,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->post(route('admin.settings.lesson.update', $lesson->id), $this->lessonPayload([
            'title' => 'Lesson With PDFs',
            'NO' => 6,
            'pdf' => [$keptPdf, $newPdf],
        ]));

        $response->assertRedirect();

        $this->assertDatabaseHas('lessons', [
            'id' => $lesson->id,
            'pdf' => $keptPdf.','.$newPdf,
        ]);

        $this->assertFalse(Storage::disk('uploads')->exists('lessons/files/'.$oldPdf));
        $this->assertTrue(Storage::disk('uploads')->exists('lessons/files/'.$keptPdf));
        $this->assertTrue(Storage::disk('uploads')->exists('lessons/files/'.$newPdf));
    }

    public function test_view_previews_all_pdfs_from_comma_separated_value(): void
    {
        $pdfOne = $this->putLessonPdfOnStorage('1710000106_view_a.pdf');
        $pdfTwo = $this->putLessonPdfOnStorage('1710000107_view_b.pdf');

        $lesson = Lesson::create([
            'title' => 'Lesson View PDFs',
            'chapter_id' => $this->chapter->id,
            'link' => '',
            'pdf' => $pdfOne.','.$pdfTwo,
            'NO' => 7,
            'watchTimes' => 1,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get(route('admin.settings.lesson.view', $lesson->id));

        $response->assertOk();
        $response->assertSee($pdfOne.','.$pdfTwo, false);
        $response->assertSee($pdfOne, false);
        $response->assertSee($pdfTwo, false);
        $response->assertSee('قيمة قاعدة البيانات (pdf)', false);
    }

    private function putLessonPdfOnStorage(string $fileName, string $content = 'fake-pdf-binary'): string
    {
        Storage::disk('uploads')->put('lessons/files/'.$fileName, $content);

        return $fileName;
    }
}
