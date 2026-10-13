@php
    $attachments = $attachments ?? [
        'images' => [],
        'pdf' => [],
    ];
@endphp

<x-admin-upload-scripts>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
