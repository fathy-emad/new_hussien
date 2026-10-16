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
    };
</script>
<script src="{{ asset('build/js/admin/upload/dropzone-core.js') }}"></script>
<script src="{{ asset('build/js/admin/upload/dropzone-file.js') }}"></script>
{{ $slot }}
@endpush
