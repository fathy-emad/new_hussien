<?php

namespace App\Http\Requests\Admin\Exams;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateEditQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'classroom' => ['required'],
            'question' => ['required', 'string'],
            'answers' => ['required', 'array', 'min:2'],
            'answers.*' => ['required', 'string'],
            'correct_answer' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'من فضلك أدخل السؤال',
            'answers.required' => 'يجب إدخال الإجابات',
            'answers.min' => 'يجب إدخال إجابتين على الأقل',
            'answers.*.required' => 'من فضلك أدخل الإجابة',
            'correct_answer.required' => 'يجب تحديد الإجابة الصحيحة',
        ];
    }
}
