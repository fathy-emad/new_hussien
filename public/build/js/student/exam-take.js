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

        const examTime = parseInt($('[data-exam-time]').attr('data-exam-time'), 10) || 0;
        let change = parseInt($('[data-change]').text(), 10) || 0;
        const progressBar = $('.student-exam-progress .progress-bar');
        const submitUrl = form.data('submit-url');
        const examsUrl = form.data('exams-url');
        const updateInterval = 60000;
        let interval;

        function setProgressBarWidth(percentage, isFinal) {
            progressBar.css('width', percentage + '%');

            if (isFinal) {
                progressBar.removeClass('progress-bar-animated');
                progressBar.css('background-color', '#dc3545');
                $('[data-change]').text('0');
            }
        }

        function updateProgress() {
            if (change > 0) {
                const percentage = ((examTime - change) / examTime) * 100;
                setProgressBarWidth(percentage, false);
                $('[data-change]').text(change);
                change--;
            } else {
                clearInterval(interval);
                setProgressBarWidth(100, true);
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
            const percentage = change > 0 ? ((examTime - change) / examTime) * 100 : 100;
            setProgressBarWidth(percentage, change === 0);
        });

        form.on('change', 'input[type=radio]', function () {
            submitData(false);
        });
    });
})(jQuery);
