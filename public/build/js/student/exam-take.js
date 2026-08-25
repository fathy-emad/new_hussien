(function ($) {
    'use strict';

    $(function () {
        const form = $('#form-submit');

        if (!form.length) {
            return;
        }

        if (form.data('readonly') === 1 || form.data('readonly') === '1') {
            return;
        }

        const progressBar = $('.student-exam-progress .progress-bar');
        const totalSeconds = (parseInt($('[data-exam-time]').attr('data-exam-time'), 10) || 0) * 60;
        const initialRemaining = parseInt(progressBar.attr('data-remaining-seconds'), 10) || 0;
        const submitUrl = form.data('submit-url');
        const examsUrl = form.data('exams-url');
        const deadline = Date.now() + (initialRemaining * 1000);
        const updateInterval = 1000;
        let interval;
        let finalSubmitted = false;

        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;

            return [hours, minutes, secs]
                .map(function (part) { return String(part).padStart(2, '0'); })
                .join(':');
        }

        function setProgressBarWidth(percentage, isFinal) {
            progressBar.css('width', percentage + '%');

            if (isFinal) {
                progressBar.removeClass('progress-bar-animated');
                progressBar.css('background-color', '#dc3545');
                $('[data-change]').text('00:00:00');
            }
        }

        function updateProgress() {
            const remaining = Math.max(0, Math.ceil((deadline - Date.now()) / 1000));
            const percentage = totalSeconds > 0
                ? Math.max(0, Math.min(100, (remaining / totalSeconds) * 100))
                : 0;

            $('[data-change]').text(formatTime(remaining));
            setProgressBarWidth(percentage, remaining === 0);

            if (remaining === 0 && !finalSubmitted) {
                finalSubmitted = true;
                clearInterval(interval);
                form.find('input[type=radio]').prop('disabled', true);
                submitData(true);
            }
        }

        function submitData(afterFinish) {
            if (afterFinish) {
                form.find('input[type=radio]').prop('disabled', false);
            }

            const formData = form.serialize() + (afterFinish ? '&final=1' : '');

            $.ajax({
                url: submitUrl,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val(),
                },
            }).always(function () {
                if (afterFinish) {
                    form.find('input[type=radio]').prop('disabled', true);
                    window.setTimeout(function () {
                        window.location.href = examsUrl;
                    }, 1500);
                }
            });
        }

        updateProgress();
        interval = setInterval(updateProgress, updateInterval);

        $(window).on('resize', function () {
            updateProgress();
        });

        form.on('change', 'input[type=radio]', function () {
            submitData(false);
        });
    });
})(jQuery);
