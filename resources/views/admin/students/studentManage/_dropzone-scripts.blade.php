@php
    $attachments = $attachments ?? ['avatar' => []];
@endphp

<x-admin-upload-scripts>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AdminDropzoneUpload.createSingle({
                elementId: 'avatar',
                storePath: 'students/images',
                inputName: 'avatar[]',
                acceptedFiles: 'image/*',
                existingFiles: @json($attachments['avatar'] ?? []),
            });
        });
    </script>
</x-admin-upload-scripts>
