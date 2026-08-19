@php
    $attachments = $attachments ?? [
        'why_us_side_image' => [],
        'featured_students_images' => [],
    ];
@endphp

<x-admin-upload-scripts>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dropzones = {};

            function initDropzone(key, factory) {
                if (dropzones[key]) {
                    if (dropzones[key].emit) {
                        dropzones[key].emit('resize');
                    }
                    return dropzones[key];
                }

                dropzones[key] = factory();
                return dropzones[key];
            }

            function initWhyUsDropzone() {
                return initDropzone('why_us', function () {
                    return AdminDropzoneUpload.createMulti({
                        elementId: 'why_us_side_image_dropzone',
                        maxFiles: 1,
                        storePath: 'website/images',
                        inputName: 'why_us_side_image[]',
                        acceptedFiles: 'image/*',
                        existingFiles: @json($attachments['why_us_side_image'] ?? []),
                    });
                });
            }

            function initFeaturedStudentsDropzone() {
                return initDropzone('featured_students', function () {
                    return AdminDropzoneUpload.createMulti({
                        elementId: 'featured_students_images_dropzone',
                        maxFiles: 20,
                        storePath: 'website/images',
                        inputName: 'featured_students_images[]',
                        acceptedFiles: 'image/*',
                        existingFiles: @json($attachments['featured_students_images'] ?? []),
                    });
                });
            }

            var whyUsPanel = document.getElementById('sectionWhyUs');
            var featuredPanel = document.getElementById('sectionFeatured');

            if (whyUsPanel) {
                if (whyUsPanel.classList.contains('show')) {
                    initWhyUsDropzone();
                }
                whyUsPanel.addEventListener('shown.bs.collapse', initWhyUsDropzone);
            }

            if (featuredPanel) {
                if (featuredPanel.classList.contains('show')) {
                    initFeaturedStudentsDropzone();
                }
                featuredPanel.addEventListener('shown.bs.collapse', initFeaturedStudentsDropzone);
            }
        });
    </script>
</x-admin-upload-scripts>
