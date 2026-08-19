<?php $page = 'login'; ?>
@extends('layout.auth')
@section('content')
    <x-auth-login-layout
        title="تسجيل دخول الإدارة"
        subtitle="أدخل البريد الإلكتروني وكلمة المرور"
        :back-url="url('/')"
        form-action="{{ route('admin.login.submit') }}"
    >
        <div class="input-block">
            <label class="form-control-label" for="email">البريد الإلكتروني</label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email"
                id="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
            >
            @error('email')
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
