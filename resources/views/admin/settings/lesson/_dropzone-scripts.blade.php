@php
    $attachments = $attachments ?? [
        'thumbnail' => [],
        'images' => [],
        'pdf' => [],
        'lessonVideo' => [],
    ];
@endphp

<x-admin-upload-scripts>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AdminDropzoneUpload.createVideo({
                elementId: 'lesson_video_dropzone',
                videoFolder: 'lessons',
                inputName: 'link',
                linkFieldId: 'lesson_video_link',
                existingFiles: @json($attachments['lessonVideo'] ?? []),
            });

            AdminDropzoneUpload.createSingle({
                elementId: 'thumbnail',
                storePath: 'lessons/images',
                inputName: 'thumbnail[]',
                acceptedFiles: 'image/*',
                existingFiles: @json($attachments['thumbnail'] ?? []),
            });

            AdminDropzoneUpload.createMulti({
                elementId: 'images',
                maxFiles: 50,
                storePath: 'lessons/images',
                inputName: 'images[]',
                acceptedFiles: 'image/*',
                existingFiles: @json($attachments['images'] ?? []),
            });

            AdminDropzoneUpload.createMulti({
                elementId: 'pdf',
                maxFiles: 50,
                storePath: 'lessons/files',
                inputName: 'pdf[]',
                csvDisplayFieldId: 'lesson_pdf_csv_display',
                acceptedFiles: '.pdf,.doc,.docx,application/pdf',
                existingFiles: @json($attachments['pdf'] ?? []),
            });
        });
    </script>
</x-admin-upload-scripts>
