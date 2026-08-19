@props([
    'exam',
    'score',
])

<div class="modal fade student-exam-result-modal" id="exam-result-modal-{{ $exam->id }}" tabindex="-1" aria-labelledby="exam-result-modal-label-{{ $exam->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exam-result-modal-label-{{ $exam->id }}">نتيجة: {{ $exam->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="admin-detail-box">
                            <span class="admin-detail-label">الدرجة</span>
                            <span class="admin-detail-value fw-semibold">{{ $score['degree_label'] }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-detail-box">
                            <span class="admin-detail-label">النسبة</span>
                            <span class="admin-detail-value fw-semibold">{{ $score['percentage'] }}%</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-detail-box">
                            <span class="admin-detail-label">الحالة</span>
                            <span class="admin-detail-value">
                                <span class="badge {{ $exam->status_badge }}">{{ $exam->status_label }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                @if ($exam->visited_at)
                    <p class="text-muted small mb-3">وقت الدخول: {{ $exam->visited_at }}</p>
                @endif

                <h6 class="mb-3">تفاصيل الإجابات</h6>
                <div class="student-exam-result-details">
                    @foreach ($score['details'] as $index => $detail)
                        <div class="student-exam-result-item mb-3 p-3 border rounded">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
                                <strong>{{ $index + 1 }}. {{ $detail['question'] }}</strong>
                                @if ($detail['is_correct'])
                                    <span class="badge bg-success">صحيحة</span>
                                @else
                                    <span class="badge bg-danger">خاطئة</span>
                                @endif
                            </div>

                            @if (! empty($detail['images']))
                                <div class="row mb-2">
                                    @foreach ($detail['images'] as $imageUrl)
                                        <div class="col-6 col-md-4 mb-2">
                                            <img src="{{ $imageUrl }}" class="img-fluid rounded" alt="صورة السؤال">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <p class="mb-1"><span class="text-muted">إجابتك:</span> {{ $detail['student_answer'] }}</p>
                            @if ($exam->status === 'completed')
                                <p class="mb-0"><span class="text-muted">الإجابة الصحيحة:</span> <span class="text-success">{{ $detail['correct_answer'] }}</span></p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
