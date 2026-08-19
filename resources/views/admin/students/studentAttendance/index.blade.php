<?php $page = 'admin-student-attendance-index'; ?>
@extends('layout.admin')

@push('styles')
    <style>
        .scan-input { letter-spacing: .08em; font-weight: 500; }
        .sticky-status { position: sticky; top: 12px; z-index: 5; }
        .attendance-recent-log .list-group-item { border-right: 0; border-left: 0; }
        .attendance-queue-badge { font-size: 0.85rem; }
    </style>
@endpush

@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            الغياب و الحضور للطلبة
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            ادارة الطلاب
        @endslot
        @slot('item3')
            الغياب و الحضور
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card admin-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                        <div>
                                            <h4 class="mb-1">تسجيل حضور بالباركود</h4>
                                            <p class="text-muted mb-0">اقرأ كود الطالب بقارئ الباركود</p>
                                        </div>
                                        <span id="queueBadge" class="badge bg-secondary attendance-queue-badge d-none">
                                            في الانتظار: <span id="queueCount">0</span>
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="centerSelect">اختر السنتر <span class="text-danger">*</span></label>
                                        <select id="centerSelect" class="form-select">
                                            <option value="">— اختر السنتر —</option>
                                            @foreach ($centers as $center)
                                                <option value="{{ $center->id }}">{{ $center->title }}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-text">لن يتم إرسال الباركود بدون اختيار السنتر.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="barcodeInput">اقرأ الباركود هنا</label>
                                        <input
                                            id="barcodeInput"
                                            type="text"
                                            class="form-control scan-input"
                                            placeholder="ضع المؤشر واقرأ الباركود"
                                            autocomplete="off"
                                        >
                                        <div class="form-text">أغلب القارئات تكتب الكود ثم تضغط Enter تلقائياً.</div>
                                    </div>

                                    <div class="sticky-status" id="statusArea"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card admin-card">
                                <div class="card-body">
                                    <h4 class="mb-3">آخر عمليات الحضور</h4>
                                    <div id="recentLog" class="list-group list-group-flush attendance-recent-log"></div>
                                    <p id="recentLogEmpty" class="text-muted text-center py-4 mb-0">لا توجد عمليات بعد.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const createUrl    = @json(route('admin.students.studentAttendance.create'));
            const csrfRefresh  = @json(route('admin.csrf-token'));
            const csrfInitial  = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const centerSelect = document.getElementById('centerSelect');
            const barcodeInput = document.getElementById('barcodeInput');
            const statusArea   = document.getElementById('statusArea');
            const recentLog    = document.getElementById('recentLog');
            const recentLogEmpty = document.getElementById('recentLogEmpty');
            const queueBadge   = document.getElementById('queueBadge');
            const queueCountEl = document.getElementById('queueCount');

            const CONCURRENCY       = 2;
            const DUP_WINDOW_MS     = 1000;
            const FLUSH_INTERVAL_MS = 8000;
            const MAX_LOG_ROWS      = 50;
            const QUEUE_KEY         = 'student_attendance_scan_queue_v1';
            const CENTER_KEY        = 'student_attendance_center_id';

            centerSelect.value = localStorage.getItem(CENTER_KEY) || '';
            centerSelect.addEventListener('change', () => {
                localStorage.setItem(CENTER_KEY, centerSelect.value);
                barcodeInput?.focus();
            });

            let pending = loadQueue();
            let active = 0;
            let pumping = false;
            const inFlight = new Set();
            const recentMap = new Map();

            function uid() {
                return Math.random().toString(36).slice(2) + Date.now().toString(36);
            }

            function loadQueue() {
                try {
                    return JSON.parse(localStorage.getItem(QUEUE_KEY) || '[]');
                } catch {
                    return [];
                }
            }

            function saveQueue() {
                try {
                    localStorage.setItem(QUEUE_KEY, JSON.stringify(pending));
                } catch {}
                updateQueueBadge();
            }

            function updateQueueBadge() {
                const count = pending.length;
                queueCountEl.textContent = String(count);
                queueBadge.classList.toggle('d-none', count === 0);
                queueBadge.classList.toggle('bg-warning', count > 0 && !navigator.onLine);
                queueBadge.classList.toggle('bg-secondary', count > 0 && navigator.onLine);
            }

            function removeFromPendingById(id) {
                const idx = pending.findIndex(i => i.id === id);
                if (idx > -1) {
                    pending.splice(idx, 1);
                    saveQueue();
                }
            }

            function toast(html, type = 'success', ttl = 6000) {
                const cls = type === 'success' ? 'alert alert-success'
                    : type === 'warning' ? 'alert alert-warning'
                        : type === 'danger' ? 'alert alert-danger'
                            : 'alert alert-secondary';
                const el = document.createElement('div');
                el.className = cls + ' mb-2';
                el.innerHTML = html;
                statusArea.prepend(el);
                setTimeout(() => el.remove(), ttl);
            }

            function logRowSuccess(res) {
                recentLogEmpty?.classList.add('d-none');
                const displayName = res.student?.name || res.student?.code || '—';
                const row = document.createElement('div');
                row.className = 'list-group-item';
                row.innerHTML = `
                    <div class="d-flex justify-content-between flex-wrap gap-2">
                        <div>
                            <span class="badge bg-success me-2">تم</span>
                            <strong>${displayName}</strong>
                            <span class="text-muted">(${res.student?.code ?? ''})</span>
                            <span class="ms-2">— ${res.center?.title ?? ''}</span>
                        </div>
                        <div class="text-muted" dir="ltr">${res.at_eg ?? ''}</div>
                    </div>`;
                recentLog.prepend(row);
                while (recentLog.children.length > MAX_LOG_ROWS) {
                    recentLog.lastElementChild?.remove();
                }
            }

            function logRowError(msg) {
                recentLogEmpty?.classList.add('d-none');
                const row = document.createElement('div');
                row.className = 'list-group-item';
                row.innerHTML = `<div><span class="badge bg-danger me-2">فشل</span> ${msg}</div>`;
                recentLog.prepend(row);
                while (recentLog.children.length > MAX_LOG_ROWS) {
                    recentLog.lastElementChild?.remove();
                }
            }

            async function refreshCsrf() {
                try {
                    const res = await fetch(csrfRefresh, {
                        headers: { 'Accept': 'application/json' },
                        credentials: 'same-origin'
                    });
                    const data = await res.json();
                    const meta = document.querySelector('meta[name="csrf-token"]');
                    if (data?.token && meta) {
                        meta.setAttribute('content', data.token);
                        return true;
                    }
                } catch {}
                return false;
            }

            async function sendPayload(payload, timeoutMs = 7000) {
                const ctrl = new AbortController();
                const t = setTimeout(() => ctrl.abort('timeout'), timeoutMs);
                try {
                    const res = await fetch(createUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || csrfInitial,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify(payload),
                        signal: ctrl.signal
                    });

                    if (res.status === 419) {
                        const ok = await refreshCsrf();
                        if (ok) {
                            clearTimeout(t);
                            return sendPayload(payload, timeoutMs);
                        }
                    }

                    let json = null;
                    try {
                        json = await res.json();
                    } catch {}

                    if (!res.ok || json?.ok === false) {
                        const msg = json?.message || `HTTP ${res.status}`;
                        const err = new Error(msg);
                        err.status = res.status;
                        throw err;
                    }

                    return json;
                } finally {
                    clearTimeout(t);
                }
            }

            function enqueueScan(code, center_id) {
                const item = {
                    id: uid(),
                    code: String(code || '').trim(),
                    center_id: Number(center_id),
                    ts: Date.now()
                };
                if (!item.code) return;
                pending.push(item);
                saveQueue();
                pump();
            }

            function pump() {
                if (pumping) return;
                pumping = true;
                try {
                    if (!navigator.onLine) return;
                    while (active < CONCURRENCY) {
                        const idx = pending.findIndex(i => !inFlight.has(i.id));
                        if (idx === -1) break;
                        processIndex(idx);
                    }
                } finally {
                    pumping = false;
                }
            }

            function processIndex(idx) {
                if (idx < 0 || idx >= pending.length) return;
                const item = pending[idx];

                if (!navigator.onLine) return;

                inFlight.add(item.id);
                active++;

                sendPayload({ code: item.code, center_id: item.center_id })
                    .then((res) => {
                        removeFromPendingById(item.id);
                        logRowSuccess(res);
                        const label = res.student?.name || res.student?.code || '';
                        toast(`تم تسجيل حضور <strong>${label}</strong> بنجاح.`, 'success');
                    })
                    .catch((e) => {
                        if (e?.status && e.status >= 400 && e.status < 500 && e.status !== 429) {
                            removeFromPendingById(item.id);
                            logRowError(e.message || 'خطأ بالبيانات');
                            toast(`تعذر تسجيل الحضور: ${e.message || 'خطأ بالبيانات'}`, 'danger');
                        }
                    })
                    .finally(() => {
                        inFlight.delete(item.id);
                        active--;
                        if (pending.length) setTimeout(pump, 0);
                    });
            }

            function isDuplicate(code) {
                const now = Date.now();
                const last = recentMap.get(code);
                recentMap.set(code, now);
                return last && (now - last) < DUP_WINDOW_MS;
            }

            barcodeInput.addEventListener('keydown', (e) => {
                if (e.key !== 'Enter') return;
                e.preventDefault();
                const center_id = centerSelect.value;
                if (!center_id) {
                    toast('الرجاء اختيار السنتر أولاً.', 'warning');
                    return;
                }
                const code = barcodeInput.value.trim();
                barcodeInput.value = '';
                if (!code) return;
                if (isDuplicate(code)) return;
                enqueueScan(code, center_id);
                if (!navigator.onLine) {
                    toast('لا يوجد اتصال — تم حفظ المسح محلياً وسيُرسل عند عودة الشبكة.', 'warning');
                }
            });

            window.addEventListener('load', () => {
                barcodeInput.focus();
                updateQueueBadge();
                pump();
            });
            window.addEventListener('online', () => {
                toast('عاد الاتصال — جاري إرسال العمليات المعلقة...', 'secondary', 4000);
                setTimeout(pump, 300);
            });
            setInterval(pump, FLUSH_INTERVAL_MS);
        })();
    </script>
@endpush
