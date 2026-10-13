<?php $page = 'student-material'; ?>
@extends('layout.student')
@section('content')
    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.student-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <div class="card admin-card">
                        <div class="card-body">
                            <h4 class="mb-4">المواد الدراسية</h4>

                            @forelse ($materials as $chapterTitle => $lessons)
                                <div class="mb-4">
                                    <h5 class="mb-3">{{ $chapterTitle }}</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>الدرس</th>
                                                    <th>المشاهدات</th>
                                                    <th>إدارة</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($lessons as $lesson)
                                                    <tr>
                                                        <td>{{ $lesson['title'] }}</td>
                                                        <td>{{ $lesson['views'] }} / {{ $lesson['watchTimes'] }}</td>
                                                        <td>
                                                            <a href="{{ route('student.lesson', $lesson['id']) }}" class="btn btn-sm btn-primary">عرض الدرس</a>
                                                            @if (! $lesson['opened'])
                                                                <span class="text-muted small d-block mt-1">الفيديو غير متاح</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">لا توجد مواد متاحة حالياً.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
