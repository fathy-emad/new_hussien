<?php $page = 'register'; ?>
@extends('layout.auth')
@section('content')
    <x-auth-login-layout
        title="إنشاء حساب طالب"
        subtitle="أدخل الكود ورقم الموبايل وكلمة المرور"
        :back-url="route('student.login')"
        back-label="العودة لتسجيل الدخول"
        form-action="{{ route('student.signup.submit') }}"
        :show-remember="false"
    >
        <div class="input-block">
            <label class="form-control-label" for="code">الكود</label>
            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code"
                value="{{ old('code') }}" required autofocus>
            @error('code')
                <div class="text-danger pt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-block">
            <label class="form-control-label" for="phone">رقم الموبايل</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone"
                value="{{ old('phone') }}" required>
            @error('phone')
                <div class="text-danger pt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-block">
            <label class="form-control-label" for="password">كلمة المرور</label>
            <div class="pass-group">
                <input type="password" class="form-control pass-input @error('password') is-invalid @enderror"
                    name="password" id="password" required>
                <span class="feather-eye-off toggle-password"></span>
            </div>
            @error('password')
                <div class="text-danger pt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-block">
            <label class="form-control-label" for="password_confirmation">تأكيد كلمة المرور</label>
            <div class="pass-group">
                <input type="password" class="form-control pass-input" name="password_confirmation"
                    id="password_confirmation" required>
                <span class="feather-eye-off toggle-password"></span>
            </div>
        </div>
    </x-auth-login-layout>
@endsection
