<?php $page = 'admin-student-cards-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            الكروت
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            ادارة الطلاب
        @endslot
        @slot('item3')
            الكروت
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <div id="createCardsQueuedAlert" class="alert alert-success alert-dismissible fade show admin-alert d-none" role="alert">
                        سيتم إشعارك بعد تجهيز ملف التحميل.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show admin-alert" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success_url'))
                        <div class="alert alert-info admin-alert">
                            <strong>رابط التحميل:</strong>
                            <a href="{{ session('success_url') }}" target="_blank" rel="noopener">{{ session('success_url') }}</a>
                        </div>
                    @endif

                    <div class="card admin-card">
                        <div class="card-body">
                            <div class="admin-card-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                <div>
                                    <h4 class="mb-1">جميع الباتشات (Batches)</h4>
                                    <p class="text-muted mb-0">إدارة كروت الطلاب وتحميلها</p>
                                </div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCardBatchModal">
                                    <i class="bx bx-plus"></i> إنشاء Batch جديد
                                </button>
                            </div>

                            <x-admin-data-table
                                :data-lables="$dataLables"
                                :data-rows="$dataRows"
                                :paginator="$batches"
                                delete-route="admin.students.studentCards.delete"
                                download-route="admin.students.studentCards.download"
                                delete-confirm="هل أنت متأكد من حذف هذا الباتش وجميع الكروت المرتبطة به؟"
                                empty-message="لا توجد batches حالياً. أنشئ batch جديد."
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createCardBatchModal" tabindex="-1" aria-labelledby="createCardBatchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="createCardBatchForm" method="POST" action="{{ route('admin.students.studentCards.create') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCardBatchModalLabel">إنشاء Batch جديد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="card_title">العنوان <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                name="title"
                                id="card_title"
                                value="{{ old('title') }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="card_count">عدد الكروت <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                class="form-control @error('count') is-invalid @enderror"
                                name="count"
                                id="card_count"
                                value="{{ old('count') }}"
                                min="1"
                                required
                            >
                            @error('count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="card_academic_year">السنة الدراسية <span class="text-danger">*</span></label>
                            <select
                                name="academic_year"
                                id="card_academic_year"
                                class="form-select @error('academic_year') is-invalid @enderror"
                                required
                            >
                                <option value="">اختر السنة الدراسية</option>
                                @foreach ($academicYears as $year => $label)
                                    <option value="{{ $year }}" @selected((string) old('academic_year') === (string) $year)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('academic_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label" for="card_classroom">الصف الدراسي <span class="text-danger">*</span></label>
                            <select
                                name="classroom"
                                id="card_classroom"
                                class="form-select @error('classroom') is-invalid @enderror"
                                required
                            >
                                <option value="">اختر الصف الدراسي</option>
                                @foreach ($classRooms as $key => $label)
                                    <option value="{{ $key }}" @selected((string) old('classroom') === (string) $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classroom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary" id="createCardBatchSubmit">إنشاء كروت للطلاب</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modalEl = document.getElementById('createCardBatchModal');
                const form = document.getElementById('createCardBatchForm');
                const submitBtn = document.getElementById('createCardBatchSubmit');
                const queuedAlert = document.getElementById('createCardsQueuedAlert');

                form?.addEventListener('submit', function () {
                    if (!form.checkValidity()) {
                        return;
                    }

                    const modal = bootstrap.Modal.getInstance(modalEl) || (modalEl ? new bootstrap.Modal(modalEl) : null);
                    modal?.hide();
                    queuedAlert?.classList.remove('d-none');
                    queuedAlert?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                    if (submitBtn) {
                        submitBtn.disabled = true;
                    }
                });

                @if ($errors->any())
                    if (modalEl) {
                        new bootstrap.Modal(modalEl).show();
                    }
                @endif

                const zipStatusUrl = @json(route('admin.students.studentCards.zip-status'));

                async function refreshDownloadButtons() {
                    const buttons = Array.from(document.querySelectorAll('[data-card-download]'));
                    if (!buttons.length) {
                        return;
                    }

                    const batches = buttons.map(function (button) {
                        return button.getAttribute('data-card-download');
                    });
                    const query = batches.map(function (batch) {
                        return 'batches[]=' + encodeURIComponent(batch);
                    }).join('&');

                    try {
                        const response = await fetch(zipStatusUrl + '?' + query, {
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                            credentials: 'same-origin'
                        });
                        if (!response.ok) {
                            return;
                        }
                        const payload = await response.json();
                        const ready = new Set((payload.ready || []).map(String));
                        buttons.forEach(function (button) {
                            const isReady = ready.has(String(button.getAttribute('data-card-download')));
                            button.classList.toggle('d-none', !isReady);
                        });
                    } catch (e) {}
                }

                refreshDownloadButtons();
                setInterval(refreshDownloadButtons, 8000);
            });
        </script>
    @endpush
@endsection
