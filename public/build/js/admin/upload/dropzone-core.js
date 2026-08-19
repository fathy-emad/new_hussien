/**
 * Shared Dropzone helpers — hidden inputs, remove API, mock files for edit forms.
 */
window.AdminDropzoneUpload = window.AdminDropzoneUpload || {};

(function (AdminDropzoneUpload) {
    'use strict';

    Dropzone.autoDiscover = false;

    AdminDropzoneUpload.defaults = {
        paramName: 'dzFiles',
        dictRemoveFile: 'حذف',
        dictCancelUpload: 'إلغاء',
        videoStorePrefix: 'videos/',
    };

    AdminDropzoneUpload.getConfig = function () {
        return window.AdminUploadConfig || {};
    };

    AdminDropzoneUpload.parseResponse = function (response) {
        if (typeof response === 'string') {
            try {
                return JSON.parse(response);
            } catch (e) {
                return { fileName: response };
            }
        }

        return response || {};
    };

    AdminDropzoneUpload.getHiddenContainer = function (elementId) {
        let container = document.getElementById(elementId + '_hidden');

        if (!container) {
            container = document.createElement('div');
            container.id = elementId + '_hidden';
            container.className = 'admin-dropzone-hidden-inputs';

            const dropzone = document.getElementById(elementId);
            const form = dropzone ? dropzone.closest('form') : null;

            if (form) {
                form.appendChild(container);
            } else if (dropzone && dropzone.parentNode) {
                dropzone.parentNode.insertBefore(container, dropzone.nextSibling);
            }
        }

        return container;
    };

    AdminDropzoneUpload.showUploadCompleteBanner = function (elementId, fileName, sizeLabel) {
        const dropzone = document.getElementById(elementId);
        if (!dropzone) {
            return;
        }

        let banner = document.getElementById(elementId + '_upload_done');

        if (!banner) {
            banner = document.createElement('div');
            banner.id = elementId + '_upload_done';
            banner.className = 'admin-upload-complete-banner alert alert-success';
            banner.setAttribute('role', 'alert');
            dropzone.parentNode.appendChild(banner);
        }

        banner.innerHTML =
            '<strong>تم رفع الفيديو بنجاح</strong><br>' +
            '<span class="admin-upload-complete-file">الملف: ' + fileName + (sizeLabel || '') + '</span><br>' +
            '<small>اضغط «حفظ» لحفظ اسم الملف في قاعدة البيانات (عمود link).</small>';

        banner.classList.remove('d-none');
    };

    AdminDropzoneUpload.syncFormField = function (inputName, fileName, fieldId) {
        let input = fieldId ? document.getElementById(fieldId) : null;

        if (!input) {
            const form = document.querySelector('form[method="POST"], form[method="post"]');
            input = form ? form.querySelector('input[name="' + inputName + '"]') : null;
        }

        if (input) {
            input.value = fileName || '';
            input.dataset.fileName = fileName || '';

            const display = document.getElementById(fieldId + '_display');
            if (display) {
                display.value = fileName || '';
            }

            const hint = document.getElementById(fieldId + '_hint');
            if (hint) {
                if (fileName) {
                    hint.textContent = 'سيتم حفظ هذا الملف في قاعدة البيانات (link): ' + fileName;
                    hint.classList.remove('d-none');
                } else {
                    hint.classList.add('d-none');
                }
            }

            return true;
        }

        return false;
    };

    AdminDropzoneUpload.syncMultiCsvDisplay = function (container, inputName, displayFieldId) {
        if (!displayFieldId) {
            return;
        }

        const display = document.getElementById(displayFieldId);
        if (!display) {
            return;
        }

        const names = [];
        const form = container.closest('form');

        if (form) {
            form.querySelectorAll('input[name="' + inputName + '"]').forEach(function (input) {
                const value = String(input.value || '').trim();
                if (value) {
                    names.push(value);
                }
            });
        } else {
            container.querySelectorAll('input[type="hidden"]').forEach(function (input) {
                if (input.name === inputName && input.value) {
                    names.push(String(input.value).trim());
                }
            });
        }

        const unique = names.filter(function (name, index) {
            return names.indexOf(name) === index;
        });

        display.value = unique.join(',');

        const hint = document.getElementById(displayFieldId + '_hint');
        if (hint) {
            if (unique.length) {
                hint.textContent =
                    'سيتم حفظ ' +
                    unique.length +
                    ' ملف في عمود pdf: ' +
                    unique.join(',');
                hint.classList.remove('d-none');
            } else {
                hint.classList.add('d-none');
            }
        }
    };

    AdminDropzoneUpload.addHiddenInput = function (container, inputName, fileName, fieldId) {
        if (AdminDropzoneUpload.syncFormField(inputName, fileName, fieldId)) {
            return;
        }

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = inputName;
        input.value = fileName;
        input.dataset.fileName = fileName;
        container.appendChild(input);
    };

    AdminDropzoneUpload.removeHiddenInput = function (container, fileName, inputName, fieldId) {
        if (AdminDropzoneUpload.syncFormField(inputName, '', fieldId)) {
            return;
        }

        container.querySelectorAll('input[type="hidden"]').forEach(function (input) {
            if (input.value === fileName || input.dataset.fileName === fileName) {
                input.remove();
            }
        });
    };

    AdminDropzoneUpload.removeUploadedFile = function (removeUrl, csrf, storePath, fileName) {
        if (!fileName || !removeUrl) {
            return;
        }

        const formData = new FormData();
        formData.append('fileName', fileName);

        fetch(removeUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'STORE-PATH': storePath,
                Accept: 'application/json',
            },
            body: formData,
        }).catch(function () {});
    };

    AdminDropzoneUpload.addMockFile = function (dz, container, inputName, file, isImage, fieldId) {
        const mock = {
            name: file.name,
            size: file.size || 0,
            accepted: true,
            status: Dropzone.SUCCESS,
            upload: { filename: file.name },
        };

        dz.emit('addedfile', mock);

        if (isImage && file.file) {
            dz.emit('thumbnail', mock, file.file);
        }

        dz.emit('complete', mock);
        dz.files.push(mock);
        AdminDropzoneUpload.addHiddenInput(container, inputName, file.name, fieldId);
    };

    AdminDropzoneUpload.buildHeaders = function (csrf, storePath) {
        return {
            'X-CSRF-TOKEN': csrf,
            'STORE-PATH': storePath,
        };
    };

    AdminDropzoneUpload.resolveUrls = function (options) {
        const config = AdminDropzoneUpload.getConfig();

        return {
            uploadUrl: options.uploadUrl || config.uploadUrl,
            removeUrl: options.removeUrl || config.removeUrl,
            csrf: options.csrf || config.csrf,
        };
    };

    AdminDropzoneUpload.formatBytes = function (bytes) {
        const value = Number(bytes) || 0;

        if (value < 1024) {
            return value + ' B';
        }

        if (value < 1024 * 1024) {
            return (value / 1024).toFixed(1) + ' KB';
        }

        if (value < 1024 * 1024 * 1024) {
            return (value / (1024 * 1024)).toFixed(1) + ' MB';
        }

        return (value / (1024 * 1024 * 1024)).toFixed(2) + ' GB';
    };

    AdminDropzoneUpload.getNotifyContainer = function () {
        let container = document.getElementById('admin-upload-notify');

        if (!container) {
            container = document.createElement('div');
            container.id = 'admin-upload-notify';
            container.className = 'admin-upload-notify-container';
            container.setAttribute('aria-live', 'polite');
            document.body.appendChild(container);
        }

        return container;
    };

    AdminDropzoneUpload.notify = function (type, message, duration) {
        const container = AdminDropzoneUpload.getNotifyContainer();
        const alert = document.createElement('div');
        const typeClass = type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'danger';

        alert.className = 'alert alert-' + typeClass + ' admin-upload-notify-alert shadow-sm';
        alert.setAttribute('role', 'alert');
        alert.textContent = message;
        container.appendChild(alert);

        window.setTimeout(function () {
            alert.classList.add('admin-upload-notify-hide');
            window.setTimeout(function () {
                alert.remove();
            }, 300);
        }, duration || 6000);
    };

    AdminDropzoneUpload.getVideoProgressPanel = function (elementId) {
        let panel = document.getElementById(elementId + '_progress');

        if (!panel) {
            const dropzone = document.getElementById(elementId);

            panel = document.createElement('div');
            panel.id = elementId + '_progress';
            panel.className = 'admin-video-upload-progress d-none';
            panel.innerHTML =
                '<div class="progress admin-video-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100">' +
                '<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"></div>' +
                '</div>' +
                '<p class="admin-video-progress-text mb-0"></p>' +
                '<p class="admin-video-progress-merge mb-0 d-none">جاري دمج الأجزاء على السيرفر...</p>';

            if (dropzone && dropzone.parentNode) {
                dropzone.parentNode.appendChild(panel);
            }
        }

        return panel;
    };

    AdminDropzoneUpload.updateVideoProgress = function (elementId, file, progress, bytesSent, merging) {
        const panel = AdminDropzoneUpload.getVideoProgressPanel(elementId);
        const bar = panel.querySelector('.progress-bar');
        const text = panel.querySelector('.admin-video-progress-text');
        const mergeText = panel.querySelector('.admin-video-progress-merge');
        const total = file.size || 0;
        const percent = Math.min(100, Math.max(0, Math.round(progress)));
        const sent = bytesSent || 0;
        const chunkIndex = file.upload && file.upload.chunks
            ? file.upload.chunks.filter(function (chunk) {
                return chunk && chunk.progress === 100;
            }).length
            : 0;
        const totalChunks = file.upload ? file.upload.totalChunkCount || 0 : 0;

        panel.classList.remove('d-none');

        if (bar) {
            bar.style.width = percent + '%';
            bar.setAttribute('aria-valuenow', String(percent));
            bar.textContent = percent + '%';
        }

        if (text) {
            let label = percent + '% — ' + AdminDropzoneUpload.formatBytes(sent);

            if (total > 0) {
                label += ' / ' + AdminDropzoneUpload.formatBytes(total);
            }

            if (totalChunks > 0) {
                label += ' — جزء ' + Math.min(chunkIndex + 1, totalChunks) + ' من ' + totalChunks;
            }

            text.textContent = label;
        }

        if (mergeText) {
            if (merging) {
                mergeText.classList.remove('d-none');
            } else {
                mergeText.classList.add('d-none');
            }
        }
    };

    AdminDropzoneUpload.hideVideoProgress = function (elementId) {
        const panel = document.getElementById(elementId + '_progress');

        if (panel) {
            panel.classList.add('d-none');
        }
    };
})(window.AdminDropzoneUpload);
