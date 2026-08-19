@props([
    'chapterLabel',
    'classroomLabel',
    'mode' => 'create',
])

<div class="alert alert-info admin-context-notice mb-4" role="status">
    @if ($mode === 'create')
        أنت تقوم بإنشاء درس جديد ضمن:
    @else
        أنت تقوم بتعديل درس ضمن:
    @endif
    <strong>الفصل {{ $chapterLabel }}</strong>
    —
    <strong>الصف الدراسي {{ $classroomLabel }}</strong>
</div>
