/**
 * Chunked large video upload (500MB+) — Dropzone → videos/{folder} on server.
 */
(function (AdminDropzoneUpload) {
    'use strict';

    AdminDropzoneUpload.createVideo = function (options) {
        const elementId = options.elementId;
        const el = document.getElementById(elementId);

        if (!el) {
            return null;
        }

        const urls = AdminDropzoneUpload.resolveUrls(options);
        const config = AdminDropzoneUpload.getConfig();
        const videoFolder = options.videoFolder || options.folder || 'lessons';
        const storePath = options.storePath || AdminDropzoneUpload.defaults.videoStorePrefix + videoFolder;
        const inputName = options.inputName || 'link';
        const linkFieldId = options.linkFieldId || 'lesson_video_link';
        const chunkSize = options.chunkSize || config.chunkSize || 2 * 1024 * 1024;
        const maxFilesize = options.maxFilesize || config.videoMaxFilesizeMb || 2048;
        const timeout = options.timeout || config.videoUploadTimeoutMs || 3600000;
        const container = AdminDropzoneUpload.getHiddenContainer(elementId);
        let merging = false;
        let lastServerFileName = '';

        function parseChunkOrUploadResponse(file, response) {
            let data = AdminDropzoneUpload.parseResponse(response);

            if ((!data.fileName || String(data.fileName).trim() === '') && file && file.xhr && file.xhr.responseText) {
                data = AdminDropzoneUpload.parseResponse(file.xhr.responseText);
            }

            return data;
        }

        function applyServerFileName(fileName) {
            const clean = fileName ? String(fileName).trim() : '';

            if (!clean) {
                return false;
            }

            lastServerFileName = clean;
            el.dataset.uploadedVideo = clean;
            AdminDropzoneUpload.syncFormField(inputName, clean, linkFieldId);

            return true;
        }

        function onVideoUploadFinished(file, data) {
            const fileName = data.fileName ? String(data.fileName).trim() : '';

            if (!fileName) {
                return;
            }

            merging = false;
            file.upload = file.upload || {};
            file.upload.filename = fileName;

            applyServerFileName(fileName);

            AdminDropzoneUpload.updateVideoProgress(elementId, file, 100, file.size || 0, false);

            const sizeLabel = data.size
                ? ' (' + AdminDropzoneUpload.formatBytes(data.size) + ')'
                : '';

            AdminDropzoneUpload.showUploadCompleteBanner(elementId, fileName, sizeLabel);

            AdminDropzoneUpload.notify(
                'success',
                'تم رفع الفيديو: ' + fileName + sizeLabel + ' — اضغط «حفظ» الآن.',
                12000
            );
        }

        const dz = new Dropzone(el, {
            url: urls.uploadUrl,
            paramName: AdminDropzoneUpload.defaults.paramName,
            maxFiles: options.maxFiles || 1,
            maxFilesize: maxFilesize,
            addRemoveLinks: true,
            createImageThumbnails: false,
            acceptedFiles: options.acceptedFiles || 'video/mp4,video/webm,video/quicktime',
            chunking: true,
            forceChunking: true,
            chunkSize: chunkSize,
            parallelChunkUploads: false,
            retryChunks: true,
            retryChunksLimit: 5,
            timeout: timeout,
            headers: AdminDropzoneUpload.buildHeaders(urls.csrf, storePath),
            dictRemoveFile: AdminDropzoneUpload.defaults.dictRemoveFile,
            dictCancelUpload: AdminDropzoneUpload.defaults.dictCancelUpload,
            dictFileTooBig: 'الملف كبير جداً (الحد الأقصى {{maxFilesize}}MB)',
            dictInvalidFileType: 'نوع الفيديو غير مدعوم',
            dictResponseError: 'فشل رفع الفيديو ({{statusCode}})',
        });

        dz.on('addedfile', function () {
            merging = false;
            lastServerFileName = '';
            delete el.dataset.uploadedVideo;
            AdminDropzoneUpload.syncFormField(inputName, '', linkFieldId);
            AdminDropzoneUpload.updateVideoProgress(elementId, dz.files[0] || {}, 0, 0, false);
        });

        dz.on('uploadprogress', function (file, progress, bytesSent) {
            const nearComplete = progress >= 98 && file.upload && file.upload.chunked;
            AdminDropzoneUpload.updateVideoProgress(elementId, file, progress, bytesSent, merging || nearComplete);
        });

        dz.on('sending', function (file, xhr) {
            xhr.upload.addEventListener('load', function () {
                if (!file.upload || !file.upload.chunked) {
                    return;
                }

                const doneChunks = file.upload.chunks
                    ? file.upload.chunks.filter(function (chunk) {
                        return chunk && chunk.progress === 100;
                    }).length
                    : 0;

                if (doneChunks >= (file.upload.totalChunkCount || 0)) {
                    merging = true;
                    AdminDropzoneUpload.updateVideoProgress(elementId, file, 99, file.size || 0, true);
                }
            });
        });

        dz.on('success', function (file, response) {
            onVideoUploadFinished(file, parseChunkOrUploadResponse(file, response));
        });

        if (typeof dz.on === 'function') {
            dz.on('chunksUploaded', function (file) {
                onVideoUploadFinished(file, parseChunkOrUploadResponse(file, null));
            });
        }

        dz.on('error', function (file, message, xhr) {
            merging = false;
            AdminDropzoneUpload.hideVideoProgress(elementId);

            let errorText = 'فشل رفع الفيديو.';

            if (xhr && xhr.responseText) {
                const data = AdminDropzoneUpload.parseResponse(xhr.responseText);
                if (data.message) {
                    errorText = data.message;
                }
            } else if (typeof message === 'string' && message) {
                errorText = message;
            } else if (message && message.message) {
                errorText = message.message;
            }

            AdminDropzoneUpload.notify('danger', errorText);
        });

        dz.on('canceled', function () {
            merging = false;
            AdminDropzoneUpload.hideVideoProgress(elementId);
            AdminDropzoneUpload.notify('warning', 'تم إلغاء رفع الفيديو.');
        });

        dz.on('complete', function (file) {
            if (file.status !== Dropzone.SUCCESS) {
                return;
            }

            const data = parseChunkOrUploadResponse(file, null);
            if (data.fileName) {
                onVideoUploadFinished(file, data);
            } else if (lastServerFileName) {
                applyServerFileName(lastServerFileName);
            } else if (file.upload && file.upload.filename) {
                applyServerFileName(file.upload.filename);
            }

            window.setTimeout(function () {
                AdminDropzoneUpload.hideVideoProgress(elementId);
            }, 2500);
        });

        dz.on('removedfile', function (file) {
            merging = false;
            lastServerFileName = '';
            delete el.dataset.uploadedVideo;
            AdminDropzoneUpload.hideVideoProgress(elementId);
            AdminDropzoneUpload.syncFormField(inputName, '', linkFieldId);

            const fileName = file.upload?.filename || file.name;
            AdminDropzoneUpload.removeHiddenInput(container, fileName, inputName, linkFieldId);
            AdminDropzoneUpload.removeUploadedFile(urls.removeUrl, urls.csrf, storePath, file.upload?.filename || fileName);
        });

        (options.existingFiles || []).forEach(function (file) {
            if (file.name && AdminDropzoneUpload.lessonVideoExistsOnServer && AdminDropzoneUpload.lessonVideoExistsOnServer(file.name)) {
                applyServerFileName(file.name);
            } else if (file.name) {
                applyServerFileName(file.name);
            }
            AdminDropzoneUpload.addMockFile(dz, container, inputName, file, false, linkFieldId);
        });

        const form = el.closest('form');
        if (form) {
            form.addEventListener('submit', function (event) {
                const linkInput = document.getElementById(linkFieldId);
                const serverName = lastServerFileName
                    || el.dataset.uploadedVideo
                    || (dz.files[0] && dz.files[0].upload && dz.files[0].upload.filename)
                    || '';

                if (!serverName) {
                    return;
                }

                const current = linkInput ? String(linkInput.value).trim() : '';
                const clientName = dz.files[0] ? String(dz.files[0].name || '').trim() : '';

                if (!current || current === clientName) {
                    applyServerFileName(serverName);
                }

                if (linkInput && !linkInput.value) {
                    event.preventDefault();
                    AdminDropzoneUpload.notify('danger', 'لم يتم ربط ملف الفيديو بالنموذج. أعد رفع الفيديو ثم احفظ.');
                }
            });
        }

        return dz;
    };

    /** @deprecated Use AdminDropzoneUpload.createVideo() */
    window.createVideoDropzone = function (
        elementId,
        uploadUrl,
        removeUrl,
        csrf,
        folder,
        existingFiles
    ) {
        return AdminDropzoneUpload.createVideo({
            elementId: elementId,
            uploadUrl: uploadUrl,
            removeUrl: removeUrl,
            csrf: csrf,
            videoFolder: folder,
            existingFiles: existingFiles,
        });
    };
})(window.AdminDropzoneUpload);
