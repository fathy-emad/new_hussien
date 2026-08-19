/**
 * @deprecated Load upload services directly:
 *   build/js/admin/upload/dropzone-core.js
 *   build/js/admin/upload/dropzone-video.js
 *   build/js/admin/upload/dropzone-file.js
 *
 * This file keeps backward compatibility for pages still including it.
 */
(function () {
    const scripts = [
        'build/js/admin/upload/dropzone-core.js',
        'build/js/admin/upload/dropzone-video.js',
        'build/js/admin/upload/dropzone-file.js',
    ];

    scripts.forEach(function (src) {
        if (document.querySelector('script[src*="' + src + '"]')) {
            return;
        }

        const tag = document.createElement('script');
        tag.src = '/' + src;
        document.head.appendChild(tag);
    });
})();
