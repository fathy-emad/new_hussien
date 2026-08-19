<?php $page = 'admin-website-reviews-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            آراء الطلاب
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            آراء الطلاب
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
                            <div class="admin-card-header mb-4">
                                <h4 class="mb-1">آراء الطلاب</h4>
                                <p class="text-muted mb-0">راجع آراء الطلاب واعتمد ما يصلح للعرض على الموقع</p>
                            </div>

                            <x-admin-data-table
                                :data-lables="$dataLables"
                                :data-rows="$dataRows"
                                :paginator="$reviews"
                                empty-message="لا توجد آراء من الطلاب حالياً."
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="adminReviewViewModal" tabindex="-1" aria-labelledby="adminReviewViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminReviewViewModalLabel">عرض الرأي</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-3">
                        <dt class="col-sm-3">الطالب</dt>
                        <dd class="col-sm-9 mb-2" id="adminReviewViewStudent">—</dd>

                        <dt class="col-sm-3">الصف</dt>
                        <dd class="col-sm-9 mb-2" id="adminReviewViewClassroom">—</dd>

                        <dt class="col-sm-3">السنة</dt>
                        <dd class="col-sm-9 mb-2" id="adminReviewViewYear">—</dd>

                        <dt class="col-sm-3">الحالة</dt>
                        <dd class="col-sm-9 mb-2" id="adminReviewViewStatus">—</dd>

                        <dt class="col-sm-3">تاريخ الإرسال</dt>
                        <dd class="col-sm-9 mb-0" id="adminReviewViewSubmitted">—</dd>
                    </dl>

                    <hr>

                    <h6 class="mb-2">نص الرأي</h6>
                    <div id="adminReviewViewBody" class="border rounded p-3 bg-light" style="white-space: pre-wrap; min-height: 120px;"></div>
                </div>
                <div class="modal-footer">
                    <a href="#" id="adminReviewViewEditLink" class="btn btn-primary">تعديل الرأي</a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var reviewDetails = @json($reviewDetails ?? []);
            var modalEl = document.getElementById('adminReviewViewModal');

            if (!modalEl) {
                return;
            }

            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            var editUrlTemplate = @json(route('admin.website.reviews.edit', ['id' => 999999]));

            document.body.addEventListener('click', function (event) {
                var btn = event.target.closest('.admin-review-view-btn');
                if (!btn) {
                    return;
                }

                var id = btn.getAttribute('data-review-id');
                var detail = reviewDetails[id];

                if (!detail) {
                    return;
                }

                document.getElementById('adminReviewViewStudent').textContent = detail.student || '—';
                document.getElementById('adminReviewViewClassroom').textContent = detail.classroom || '—';
                document.getElementById('adminReviewViewYear').textContent = detail.year || '—';
                document.getElementById('adminReviewViewStatus').textContent = detail.status || '—';
                document.getElementById('adminReviewViewSubmitted').textContent = detail.submitted_at || '—';
                document.getElementById('adminReviewViewBody').textContent = detail.body || '';
                document.getElementById('adminReviewViewEditLink').href = editUrlTemplate.replace('999999', id);

                modal.show();
            });
        });
    </script>
@endpush
