<?php $page = 'contact'; ?>
@extends('layout.mainlayout')

@section('page-title', 'تواصل معنا — منصة مستر حسين')

@section('content')
    <div class="breadcrumb-bar breadcrumb-bar-info">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="breadcrumb-info">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">تواصل معنا</li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title">تواصل معنا</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-10 mx-auto">
                    <div class="support-wrap">
                        <h5>أرسل استفسارك</h5>
                        <p class="text-muted mb-4">
                            اكتب رسالتك ورقم هاتفك وسيتواصل معك فريق مستر حسين في أقرب وقت.
                        </p>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('website_asks') }}" method="POST">
                            @csrf
                            <div class="input-block">
                                <label for="contact-phone">رقم الهاتف</label>
                                <input type="text" id="contact-phone" name="phone" class="form-control"
                                    value="{{ old('phone') }}" placeholder="01xxxxxxxxx" required>
                            </div>
                            <div class="input-block">
                                <label for="contact-content">الرسالة</label>
                                <textarea id="contact-content" name="content" class="form-control" rows="5"
                                    placeholder="اكتب استفسارك هنا..." required>{{ old('content') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-submit">إرسال</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
