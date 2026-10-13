@props([
    'uploadRoute' => 'admin.fileUpload',
    'removeRoute' => 'admin.removeFileUploaded',
])

@push('scripts')
<script>
    window.AdminUploadConfig = {
        uploadUrl: @json(route($uploadRoute)),
        removeUrl: @json(route($removeRoute)),
        csrf: @json(csrf_token()),
        chunkSize: @json((int) config('upload.chunk_size')),
        videoMaxFilesizeMb: @json((int) config('upload.video_max_filesize_mb')),
        videoUploadTimeoutMs: @json((int) config('upload.video_upload_timeout_ms')),
        videoStorePrefix: 'videos/',
    };
</script>
<script src="{{ asset('build/js/admin/upload/dropzone-core.js') }}"></script>
<script src="{{ asset('build/js/admin/upload/dropzone-file.js') }}"></script>
{{ $slot }}
@endpush
