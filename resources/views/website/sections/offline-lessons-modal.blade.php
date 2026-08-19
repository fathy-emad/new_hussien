<div class="modal fade offline-lessons-modal" id="offlineLessonsModal" tabindex="-1" aria-labelledby="offlineLessonsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="offlineLessonsModalLabel">جميع دروس Offline</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                @foreach ($offlineLessonsByClassroom as $classKey => $group)
                    <div class="offline-lessons-classroom-block mb-4">
                        <h6 class="offline-lessons-classroom-title">{{ $group['label'] }}</h6>

                        @if ($group['lessons']->isEmpty())
                            <p class="text-muted small mb-0">لا توجد دروس في هذا الصف حالياً.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($group['lessons'] as $lesson)
                                    <li class="list-group-item px-0 offline-lessons-modal-item">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="offline-lessons-modal-logo flex-shrink-0">
                                                <img src="{{ \App\Support\WebsiteHomepage::offlineLessonLogo() }}" alt="">
                                            </div>
                                            <div class="flex-grow-1 min-w-0">
                                                <strong class="d-block mb-1">{{ $lesson->title }}</strong>
                                                @if ($lesson->description)
                                                    <p class="text-muted small mb-2">
                                                        {{ \Illuminate\Support\Str::limit(strip_tags($lesson->description), 140) }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button
                                                    type="button"
                                                    class="btn btn-primary btn-sm offline-open-lesson-btn"
                                                    data-lesson-id="{{ $lesson->id }}"
                                                    data-lesson-title="{{ $lesson->title }}"
                                                >
                                                    فتح الدرس
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
