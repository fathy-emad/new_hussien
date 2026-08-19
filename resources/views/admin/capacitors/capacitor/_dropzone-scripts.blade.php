@php
    $attachments = $attachments ?? [
        'images' => [],
        'pdf' => [],
        'lessonVideo' => [],
    ];
@endphp

<x-admin-upload-scripts>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AdminDropzoneUpload.createVideo({
                elementId: 'capacitor_video_dropzone',
                videoFolder: 'capacitors',
                inputName: 'link',
                linkFieldId: 'capacitor_video_link',
                existingFiles: @json($attachments['lessonVideo'] ?? []),
            });

            AdminDropzoneUpload.createMulti({
                elementId: 'offline_images',
                maxFiles: 50,
                storePath: 'capacitors/lessons/images',
                inputName: 'images[]',
                acceptedFiles: 'image/*',
                existingFiles: @json($attachments['images'] ?? []),
            });

            AdminDropzoneUpload.createMulti({
                elementId: 'offline_pdf',
                maxFiles: 50,
                storePath: 'capacitors/lessons/files',
                inputName: 'pdf[]',
                csvDisplayFieldId: 'offline_pdf_csv_display',
                acceptedFiles: '.pdf,.doc,.docx,application/pdf',
                existingFiles: @json($attachments['pdf'] ?? []),
            });
        });
    </script>
</x-admin-upload-scripts>
