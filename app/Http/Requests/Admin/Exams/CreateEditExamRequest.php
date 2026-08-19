<?php

namespace App\Http\Requests\Admin\Exams;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateEditExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'classroom' => ['required'],
            'day' => ['required', 'date'],
            'time' => ['required', 'integer', 'min:1'],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*' => ['required', 'integer', 'exists:bank_questions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'يجب إدخال عنوان الامتحان',
            'classroom.required' => 'يجب اختيار الصف الدراسي',
            'day.required' => 'يجب إدخال يوم الامتحان',
            'time.required' => 'يجب إدخال مدة الامتحان بالدقائق',
            'questions.required' => 'يجب اختيار أسئلة للامتحان',
            'questions.min' => 'يجب اختيار سؤال واحد على الأقل',
        ];
    }
}
