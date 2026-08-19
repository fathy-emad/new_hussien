@php
    $question = $question ?? null;
    $classRooms = $classRooms ?? [];
    $searchParams = $searchParams ?? [];
    $oldAnswers = old('answers', $question?->answers ?? ['', '']);
    if (! is_array($oldAnswers) || count($oldAnswers) < 2) {
        $oldAnswers = array_values(array_merge($oldAnswers, ['', '']));
    }
    $correctAnswer = old('correct_answer', $question?->correct_answer ?? 0);
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="input-block mb-3">
            <label class="form-label" for="classroom">الصف الدراسي <span class="text-danger">*</span></label>
            <select
                name="classroom"
                id="classroom"
                class="form-select @error('classroom') is-invalid @enderror"
                required
            >
                <option value="">اختر الصف الدراسي</option>
                @foreach ($classRooms as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected((string) old('classroom', $question?->classroom ?? $searchParams['classroom'] ?? '') === (string) $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('classroom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-block mb-3">
            <label class="form-label" for="question">السؤال <span class="text-danger">*</span></label>
            <textarea
                class="form-control @error('question') is-invalid @enderror"
                name="question"
                id="question"
                rows="3"
                required
            >{{ old('question', $question?->question) }}</textarea>
            @error('question')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-block mb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                <label class="form-label mb-0">الإجابات <span class="text-danger">*</span></label>
                <button type="button" class="btn btn-sm btn-outline-primary" id="exam_add_answer">
                    <i class="bx bx-plus"></i> إضافة إجابة
                </button>
            </div>
            <p class="text-muted small mb-3">حدد الإجابة الصحيحة باستخدام زر الاختيار بجانب كل إجابة</p>

            <div id="exam_answers_list" class="d-flex flex-column gap-2">
                @foreach ($oldAnswers as $index => $answer)
                    <div class="exam-answer-row d-flex flex-wrap align-items-center gap-2" data-index="{{ $index }}">
                        <div class="form-check mb-0">
                            <input
                                type="radio"
                                class="form-check-input exam-correct-answer"
                                name="correct_answer"
                                id="correct_answer_{{ $index }}"
                                value="{{ $index }}"
                                @checked((string) $correctAnswer === (string) $index)
                                required
                            >
                            <label class="form-check-label visually-hidden" for="correct_answer_{{ $index }}">صحيحة</label>
                        </div>
                        <input
                            type="text"
                            class="form-control flex-grow-1 @error('answers.' . $index) is-invalid @enderror"
                            name="answers[]"
                            value="{{ $answer }}"
                            placeholder="الإجابة {{ $index + 1 }}"
                            required
                        >
                        <button type="button" class="btn btn-outline-danger btn-sm exam-remove-answer" @disabled(count($oldAnswers) <= 2)>
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            @error('answers')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            @error('answers.*')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            @error('correct_answer')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <x-admin-dropzone
            id="question_images"
            label="صور السؤال (اختياري)"
            title="اضغط لإضافة صور"
            description="يمكن رفع عدة صور"
        >
            @error('image')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </x-admin-dropzone>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const list = document.getElementById('exam_answers_list');
            const addBtn = document.getElementById('exam_add_answer');

            function reindexAnswers() {
                const rows = list.querySelectorAll('.exam-answer-row');
                let checkedIndex = null;
                rows.forEach(function (row, index) {
                    row.dataset.index = index;
                    const radio = row.querySelector('.exam-correct-answer');
                    const label = row.querySelector('label[for^="correct_answer_"]');
                    const input = row.querySelector('input[name="answers[]"]');
                    const removeBtn = row.querySelector('.exam-remove-answer');

                    if (radio.checked) {
                        checkedIndex = index;
                    }

                    radio.id = 'correct_answer_' + index;
                    radio.value = index;
                    if (label) {
                        label.setAttribute('for', 'correct_answer_' + index);
                    }
                    input.placeholder = 'الإجابة ' + (index + 1);
                    removeBtn.disabled = rows.length <= 2;
                });

                if (checkedIndex !== null) {
                    const checkedRadio = list.querySelector('#correct_answer_' + checkedIndex);
                    if (checkedRadio) {
                        checkedRadio.checked = true;
                    }
                }
            }

            addBtn.addEventListener('click', function () {
                const index = list.querySelectorAll('.exam-answer-row').length;
                const row = document.createElement('div');
                row.className = 'exam-answer-row d-flex flex-wrap align-items-center gap-2';
                row.dataset.index = index;
                row.innerHTML =
                    '<div class="form-check mb-0">' +
                        '<input type="radio" class="form-check-input exam-correct-answer" name="correct_answer" id="correct_answer_' + index + '" value="' + index + '">' +
                        '<label class="form-check-label visually-hidden" for="correct_answer_' + index + '">صحيحة</label>' +
                    '</div>' +
                    '<input type="text" class="form-control flex-grow-1" name="answers[]" placeholder="الإجابة ' + (index + 1) + '" required>' +
                    '<button type="button" class="btn btn-outline-danger btn-sm exam-remove-answer"><i class="bx bx-trash"></i></button>';
                list.appendChild(row);
                reindexAnswers();
            });

            list.addEventListener('click', function (event) {
                const removeBtn = event.target.closest('.exam-remove-answer');
                if (! removeBtn || removeBtn.disabled) {
                    return;
                }
                const row = removeBtn.closest('.exam-answer-row');
                if (row) {
                    row.remove();
                    reindexAnswers();
                }
            });
        });
    </script>
@endpush
