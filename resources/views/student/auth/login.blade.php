<?php $page = 'student-login'; ?>
@extends('layout.auth')
@section('content')
    <x-auth-login-layout
        title="تسجيل دخول الطالب"
        subtitle="أدخل الكود وكلمة المرور"
        :back-url="url('/')"
        form-action="{{ route('student.login.submit') }}"
    >
        <div class="input-block">
            <label class="form-control-label" for="code">الكود</label>
            <input
                type="text"
                class="form-control @error('code') is-invalid @enderror"
                name="code"
                id="code"
                value="{{ old('code') }}"
                required
                autofocus
                autocomplete="username"
            >
            @error('code')
                <div class="text-danger pt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-block">
            <label class="form-control-label" for="password">كلمة المرور</label>
            <div class="pass-group">
                <input
                    type="password"
                    class="form-control pass-input @error('password') is-invalid @enderror"
                    name="password"
                    id="password"
                    required
                    autocomplete="current-password"
                >
                <span class="feather-eye-off toggle-password"></span>
            </div>
            @error('password')
                <div class="text-danger pt-2">{{ $message }}</div>
            @enderror
        </div>
    </x-auth-login-layout>
@endsection
