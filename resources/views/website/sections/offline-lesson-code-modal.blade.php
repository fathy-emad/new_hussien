<div class="modal fade offline-lesson-code-modal" id="offlineLessonCodeModal" tabindex="-1" aria-labelledby="offlineLessonCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="offlineLessonCodeForm" method="POST" action="{{ route('capacitor') }}">
                @csrf
                <input type="hidden" name="lesson_id" id="offline_code_lesson_id" value="">

                <div class="modal-header">
                    <h5 class="modal-title" id="offlineLessonCodeModalLabel">فتح الدرس</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted mb-3">
                        أدخل كود الكارت للوصول إلى الدرس:
                        <strong id="offlineCodeModalLessonTitle" class="text-dark"></strong>
                    </p>

                    <div class="input-block mb-0">
                        <label class="form-label" for="offline_code_input">كود الدرس</label>
                        <input
                            type="text"
                            class="form-control"
                            id="offline_code_input"
                            name="code"
                            required
                            autocomplete="off"
                            placeholder="أدخل الكود هنا"
                        >
                        <div id="offline_code_error" class="invalid-feedback d-block"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="offline_code_submit">متابعة</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
