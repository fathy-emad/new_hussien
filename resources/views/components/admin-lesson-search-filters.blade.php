@props([
    'action',
    'classRooms' => [],
    'chaptersByClassroom' => [],
    'searchParams' => [],
])

<div class="admin-search-filters card admin-card mb-4">
    <div class="card-body">
        <h5 class="admin-search-title mb-3">عناصر البحث</h5>
        <form method="GET" action="{{ $action }}" class="admin-search-form" id="admin-lesson-search-form">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label" for="lesson_classroom">الصف الدراسي</label>
                    <select
                        name="classroom"
                        id="lesson_classroom"
                        class="form-select"
                        required
                    >
                        <option value="">اختر الصف الدراسي</option>
                        @foreach ($classRooms as $key => $label)
                            <option value="{{ $key }}"
                                @selected((string) old('classroom', $searchParams['classroom'] ?? '') === (string) $key)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label" for="lesson_chapter_id">الفصل</label>
                    <select
                        name="chapter_id"
                        id="lesson_chapter_id"
                        class="form-select"
                        required
                        @disabled(empty($searchParams['classroom']))
                    >
                        <option value="">اختر الفصل</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-search"></i> بحث
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        const chaptersByClassroom = @json($chaptersByClassroom);
        const classroomSelect = document.getElementById('lesson_classroom');
        const chapterSelect = document.getElementById('lesson_chapter_id');
        const selectedClassroom = @json((string) ($searchParams['classroom'] ?? ''));
        const selectedChapterId = @json((string) ($searchParams['chapter_id'] ?? ''));

        function renderChapters(classroom, selectedId) {
            chapterSelect.innerHTML = '<option value="">اختر الفصل</option>';
            const chapters = chaptersByClassroom[classroom] || [];

            chapters.forEach(function (chapter) {
                const option = document.createElement('option');
                option.value = chapter.id;
                option.textContent = chapter.label;
                if (String(selectedId) === String(chapter.id)) {
                    option.selected = true;
                }
                chapterSelect.appendChild(option);
            });

            chapterSelect.disabled = !classroom || chapters.length === 0;
        }

        classroomSelect.addEventListener('change', function () {
            renderChapters(this.value, '');
        });

        if (selectedClassroom) {
            renderChapters(selectedClassroom, selectedChapterId);
        }
    })();
</script>
