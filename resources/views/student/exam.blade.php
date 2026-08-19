<?php $page = 'student-exam-take'; ?>
@extends('layout.student')
@section('content')
    <div class="page-content student-exam-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card admin-card mb-4">
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
                                <div>
                                    <h4 class="mb-1">{{ $exam->title }}</h4>
                                    <p class="text-muted mb-0">
                                        مدة الامتحان:
                                        <strong data-exam-time="{{ (int) $exam->time }}">{{ (int) $exam->time }}</strong>
                                        دقيقة
                                    </p>
                                </div>
                                <a href="{{ route('student.exams') }}" class="btn btn-outline-secondary btn-sm">رجوع للامتحانات</a>
                            </div>

                            @if ($readonly)
                                <div class="alert alert-warning mb-0">
                                    @if ($tested)
                                        انتهى يوم الامتحان — تظهر الإجابات الصحيحة باللون الأخضر.
                                    @else
                                        انتهى وقت الامتحان — لا يمكن تعديل الإجابات.
                                    @endif
                                </div>
                            @else
                                <div class="student-exam-timer">
                                    <div class="progress student-exam-progress" style="height: 50px;">
                                        <div
                                            class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar"
                                            style="width: 100%"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                        >
                                            المتبقي
                                            <strong class="ms-1" data-change>{{ $remainingMinutes }}</strong>
                                            دقيقة
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <form
                        method="POST"
                        id="form-submit"
                        action="{{ route('student.exam.submit') }}"
                        data-readonly="{{ $readonly ? '1' : '0' }}"
                        data-submit-url="{{ route('student.exam.submit') }}"
                        data-exams-url="{{ route('student.exams') }}"
                    >
                        @csrf
                        <input type="hidden" name="exam_id" value="{{ $examStudentId }}">

                        @foreach ($questionCards as $card)
                            @php
                                $question = $card['question'];
                                $answers = is_array($question->answers) ? $question->answers : [];
                            @endphp
                            <div class="card admin-card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">{{ $card['key'] + 1 }}. {{ $question->question }}</h5>
                                </div>
                                <div class="card-body">
                                    @if (count($card['images']))
                                        <div class="row mb-3">
                                            @foreach ($card['images'] as $imageUrl)
                                                <div class="col-sm-6 col-lg-4 mb-2">
                                                    <a href="{{ $imageUrl }}" target="_blank" rel="noopener">
                                                        <img src="{{ $imageUrl }}" class="img-fluid rounded" alt="صورة السؤال">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <p class="form-label fw-semibold mb-2">الإجابة</p>
                                    <div class="student-exam-answers">
                                        @foreach ($answers as $index => $answer)
                                            <label class="form-check student-exam-answer-option mb-2">
                                                <input type="hidden" name="questionsAnswers[{{ $card['key'] }}][question]" value="{{ $card['question_id'] }}">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="questionsAnswers[{{ $card['key'] }}][answer]"
                                                    value="{{ $index }}"
                                                    @checked((string) $index === (string) $card['selected_answer'])
                                                    @disabled($readonly)
                                                >
                                                <span class="form-check-label {{ $tested && (string) $index === (string) $question->correct_answer ? 'text-success fw-semibold' : '' }}">
                                                    {{ $answer }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('build/js/student/exam-take.js') }}"></script>
@endpush
