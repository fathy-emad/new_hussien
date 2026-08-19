/**
 * Single / multi file upload (images, PDF, documents) → public/uploads.
 */
(function (AdminDropzoneUpload) {
    'use strict';

    function createFileDropzone(options) {
        const elementId = options.elementId;
        const el = document.getElementById(elementId);

        if (!el) {
            return null;
        }

        const urls = AdminDropzoneUpload.resolveUrls(options);
        const storePath = options.storePath;
        const inputName = options.inputName;
        const isImage = (options.acceptedFiles || '').indexOf('image') !== -1;
        const container = AdminDropzoneUpload.getHiddenContainer(elementId);
        const maxFiles = options.maxFiles || 1;
        const singleFile = maxFiles === 1;
        const csvDisplayFieldId = options.csvDisplayFieldId || null;

        function syncCsvPreview() {
            if (!csvDisplayFieldId) {
                return;
            }

            AdminDropzoneUpload.syncMultiCsvDisplay(container, inputName, csvDisplayFieldId);
        }

        const dz = new Dropzone(el, {
            url: urls.uploadUrl,
            paramName: AdminDropzoneUpload.defaults.paramName,
            maxFiles: maxFiles,
            addRemoveLinks: true,
            acceptedFiles: options.acceptedFiles,
            headers: AdminDropzoneUpload.buildHeaders(urls.csrf, storePath),
            dictRemoveFile: AdminDropzoneUpload.defaults.dictRemoveFile,
            dictCancelUpload: AdminDropzoneUpload.defaults.dictCancelUpload,
        });

        dz.on('success', function (file, response) {
            const data = AdminDropzoneUpload.parseResponse(response);
            const fileName = data.fileName || data;

            if (!fileName) {
                return;
            }

            file.upload = file.upload || {};
            file.upload.filename = fileName;

            if (singleFile) {
                container.innerHTML = '';
            }

            AdminDropzoneUpload.addHiddenInput(container, inputName, fileName);
            syncCsvPreview();
        });

        dz.on('removedfile', function (file) {
            const fileName = file.upload?.filename || file.name;
            AdminDropzoneUpload.removeHiddenInput(container, fileName, inputName);
            AdminDropzoneUpload.removeUploadedFile(urls.removeUrl, urls.csrf, storePath, fileName);
            syncCsvPreview();
        });

        (options.existingFiles || []).forEach(function (file) {
            AdminDropzoneUpload.addMockFile(dz, container, inputName, file, isImage);
        });

        syncCsvPreview();

        return dz;
    }

    AdminDropzoneUpload.createSingle = function (options) {
        return createFileDropzone(Object.assign({ maxFiles: 1 }, options));
    };

    AdminDropzoneUpload.createMulti = function (options) {
        return createFileDropzone(Object.assign({ maxFiles: options.maxFiles || 50 }, options));
    };

    /** @deprecated Use AdminDropzoneUpload.createSingle() */
    window.createSingleFileDropzone = function (
        elementId,
        uploadUrl,
        removeUrl,
        csrf,
        storePath,
        inputName,
        acceptedFiles,
        existingFiles
    ) {
        return AdminDropzoneUpload.createSingle({
            elementId: elementId,
            uploadUrl: uploadUrl,
            removeUrl: removeUrl,
            csrf: csrf,
            storePath: storePath,
            inputName: inputName,
            acceptedFiles: acceptedFiles,
            existingFiles: existingFiles,
        });
    };

    /** @deprecated Use AdminDropzoneUpload.createMulti() */
    window.createMultiFileDropzone = function (
        elementId,
        maxFiles,
        acceptedFiles,
        uploadUrl,
        removeUrl,
        csrf,
        storePath,
        existingFiles,
        inputName
    ) {
        return AdminDropzoneUpload.createMulti({
            elementId: elementId,
            maxFiles: maxFiles,
            acceptedFiles: acceptedFiles,
            uploadUrl: uploadUrl,
            removeUrl: removeUrl,
            csrf: csrf,
            storePath: storePath,
            existingFiles: existingFiles,
            inputName: inputName,
        });
    };
})(window.AdminDropzoneUpload);
