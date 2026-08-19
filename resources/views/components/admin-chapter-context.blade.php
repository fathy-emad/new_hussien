@props([
    'academicYear',
    'classroomLabel',
    'mode' => 'create',
])

<div class="alert alert-info admin-context-notice mb-4" role="status">
    @if ($mode === 'create')
        أنت تقوم بإنشاء فصل جديد ضمن:
    @else
        أنت تقوم بتعديل فصل ضمن:
    @endif
    <strong>السنة الدراسية {{ $academicYear }}</strong>
    —
    <strong>الصف الدراسي {{ $classroomLabel }}</strong>
</div>
