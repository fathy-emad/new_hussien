(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var codeModalEl = document.getElementById('offlineLessonCodeModal');
        var codeForm = document.getElementById('offlineLessonCodeForm');
        var lessonIdInput = document.getElementById('offline_code_lesson_id');
        var lessonTitleEl = document.getElementById('offlineCodeModalLessonTitle');
        var codeInput = document.getElementById('offline_code_input');
        var errorEl = document.getElementById('offline_code_error');
        var submitBtn = document.getElementById('offline_code_submit');
        var listModalEl = document.getElementById('offlineLessonsModal');

        if (!codeModalEl || !codeForm) {
            return;
        }

        var codeModal = bootstrap.Modal.getOrCreateInstance(codeModalEl);

        document.body.addEventListener('click', function (event) {
            var btn = event.target.closest('.offline-open-lesson-btn');
            if (!btn) {
                return;
            }

            lessonIdInput.value = btn.getAttribute('data-lesson-id') || '';
            lessonTitleEl.textContent = btn.getAttribute('data-lesson-title') || '';
            codeInput.value = '';
            errorEl.textContent = '';
            codeInput.classList.remove('is-invalid');

            if (listModalEl) {
                var listModal = bootstrap.Modal.getInstance(listModalEl);
                if (listModal) {
                    listModal.hide();
                }
            }

            codeModal.show();
            setTimeout(function () {
                codeInput.focus();
            }, 300);
        });

        codeForm.addEventListener('submit', function (event) {
            event.preventDefault();

            errorEl.textContent = '';
            codeInput.classList.remove('is-invalid');
            submitBtn.disabled = true;

            fetch(codeForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: new FormData(codeForm),
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { ok: response.ok, data: data };
                    });
                })
                .then(function (result) {
                    if (result.ok && result.data.success && result.data.redirect) {
                        window.location.href = result.data.redirect;
                        return;
                    }

                    var message = 'كود غير صحيح، حاول مرة أخرى.';
                    if (result.data.errors) {
                        if (result.data.errors.code) {
                            message = Array.isArray(result.data.errors.code)
                                ? result.data.errors.code[0]
                                : result.data.errors.code;
                        } else if (result.data.errors.lesson_id) {
                            message = result.data.errors.lesson_id[0];
                        }
                    }

                    errorEl.textContent = message;
                    codeInput.classList.add('is-invalid');
                })
                .catch(function () {
                    errorEl.textContent = 'حدث خطأ، حاول مرة أخرى.';
                    codeInput.classList.add('is-invalid');
                })
                .finally(function () {
                    submitBtn.disabled = false;
                });
        });
    });
})();
