<?php $page = 'student-profile'; ?>
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
                            <h4 class="mb-4">الملف الشخصي</h4>

                            @if ($barcode)
                                <div class="student-checkin-barcode-section mb-4">
                                    <x-student-checkin-barcode :code="$student->code" :barcode="$barcode" />
                                </div>
                            @endif

                            <form method="POST" action="{{ route('student.updateProfile') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="name">الاسم</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $student->name) }}">
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="email">البريد الإلكتروني</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $student->email) }}">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">الكود</label>
                                        <input type="text" class="form-control" value="{{ $student->code }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="phone">رقم الموبايل</label>
                                        <input
                                            type="text"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            name="phone"
                                            id="phone"
                                            value="{{ old('phone', $student->phone) }}"
                                            inputmode="numeric"
                                            maxlength="11"
                                            pattern="[0-9]{11}"
                                            required
                                        >
                                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="password">كلمة مرور جديدة (اختياري)</label>
                                        <div class="pass-group">
                                            <input type="password" class="form-control pass-input @error('password') is-invalid @enderror" name="password" id="password">
                                            <span class="feather-eye-off toggle-password" role="button" aria-label="إظهار أو إخفاء كلمة المرور"></span>
                                        </div>
                                        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="password_confirmation">تأكيد كلمة المرور</label>
                                        <div class="pass-group">
                                            <input type="password" class="form-control pass-input @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                                            <span class="feather-eye-off toggle-password" role="button" aria-label="إظهار أو إخفاء تأكيد كلمة المرور"></span>
                                        </div>
                                        @error('password_confirmation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
