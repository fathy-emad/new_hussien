<?php $page = 'admin-website-requests-view'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            عرض استفسار
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            طلبات الموقع
        @endslot
        @slot('item2Url')
            {{ route('admin.website.requests.index') }}
        @endslot
        @slot('item3')
            عرض استفسار
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <div class="card admin-card">
                        <div class="card-body">
                            <div class="admin-card-header mb-4 d-flex flex-wrap justify-content-between align-items-start gap-2">
                                <div>
                                    <h4 class="mb-1">تفاصيل الاستفسار</h4>
                                    <p class="text-muted mb-0">
                                        @if ($ask->created_at)
                                            {{ $ask->created_at->format('d M Y - H:i:s') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('admin.website.requests.index') }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
                                    <form
                                        method="POST"
                                        action="{{ route('admin.website.requests.delete', $ask->id) }}"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا الاستفسار؟');"
                                    >
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bx bx-trash"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-2">رقم الهاتف</h6>
                                    <p class="mb-0 fs-5">{{ $ask->phone ?: '—' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-2">حالة القراءة</h6>
                                    <x-admin-website-request-read-toggle :id="$ask->id" :read="(bool) $ask->is_read" />
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted mb-2">نص الاستفسار</h6>
                                    <div class="border rounded p-3 bg-light">
                                        {!! nl2br(e($ask->content ?? '')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
