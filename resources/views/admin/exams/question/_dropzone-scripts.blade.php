@php
    $attachments = $attachments ?? ['image' => []];
@endphp

<x-admin-upload-scripts>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AdminDropzoneUpload.createMulti({
                elementId: 'question_images',
                maxFiles: 20,
                storePath: 'exams/questions/images',
                inputName: 'image[]',
                acceptedFiles: 'image/*',
                existingFiles: @json($attachments['image'] ?? []),
            });
        });
    </script>
</x-admin-upload-scripts>
