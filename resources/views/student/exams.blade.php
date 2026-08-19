<?php $page = 'student-exams'; ?>
@extends('layout.student')
@section('content')
    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.student-sidebar')

                <div class="col-xl-9 col-lg-9">
                    <div class="card admin-card mb-4">
                        <div class="card-body">
                            <h4 class="mb-4">امتحانات اليوم</h4>
                            @if ($openedExams->isEmpty())
                                <p class="text-muted mb-0">لا توجد امتحانات مفتوحة اليوم.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>العنوان</th>
                                                <th>المدة</th>
                                                <th>الحالة</th>
                                                <th>النتيجة</th>
                                                <th>إدارة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($openedExams as $exam)
                                                <tr>
                                                    <td>{{ $exam->title }}</td>
                                                    <td>{{ $exam->time }} دقيقة</td>
                                                    <td>
                                                        <span class="badge {{ $exam->status_badge }}">{{ $exam->status_label }}</span>
                                                    </td>
                                                    <td>{{ $exam->attended ? $exam->degree : '—' }}</td>
                                                    <td>
                                                        @if ($exam->status === 'not_attended')
                                                            <a href="{{ route('student.exam.open', $exam->id) }}" class="btn btn-sm btn-primary">بدء الامتحان</a>
                                                        @elseif ($exam->status === 'in_progress')
                                                            <a href="{{ route('student.exam.open', $exam->id) }}" class="btn btn-sm btn-primary">متابعة الامتحان</a>
                                                        @else
                                                            <a href="{{ route('student.exam.open', $exam->id) }}" class="btn btn-sm btn-outline-secondary">عرض الإجابات</a>
                                                            @if ($exam->attended && ! empty($exam->score_details))
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-sm btn-outline-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exam-result-modal-{{ $exam->id }}"
                                                                >
                                                                    النتيجة
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card admin-card mb-4">
                        <div class="card-body">
                            <h4 class="mb-4">امتحانات قادمة</h4>
                            @if ($futureExams->isEmpty())
                                <p class="text-muted mb-0">لا توجد امتحانات قادمة.</p>
                            @else
                                <ul class="list-group">
                                    @foreach ($futureExams as $exam)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $exam->title }}</span>
                                            <span class="text-muted">{{ $exam->day?->format('d M Y') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <div class="card admin-card">
                        <div class="card-body">
                            <h4 class="mb-4">امتحانات سابقة</h4>
                            @if ($oldExams->isEmpty())
                                <p class="text-muted mb-0">لا توجد امتحانات سابقة.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>العنوان</th>
                                                <th>التاريخ</th>
                                                <th>الحالة</th>
                                                <th>النتيجة</th>
                                                <th>إدارة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($oldExams as $exam)
                                                <tr>
                                                    <td>{{ $exam->title }}</td>
                                                    <td>{{ $exam->day?->format('d M Y') }}</td>
                                                    <td>
                                                        <span class="badge {{ $exam->status_badge }}">{{ $exam->status_label }}</span>
                                                    </td>
                                                    <td>{{ $exam->degree ?? '—' }}</td>
                                                    <td>
                                                        @if ($exam->attended && ! empty($exam->score_details))
                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#exam-result-modal-{{ $exam->id }}"
                                                            >
                                                                عرض النتيجة
                                                            </button>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($openedExams->merge($oldExams) as $exam)
        @if ($exam->attended && ! empty($exam->score_details))
            @include('components.student-exam-result-modal', [
                'exam' => $exam,
                'score' => $exam->score_details,
            ])
        @endif
    @endforeach
@endsection
