<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditChapterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'academic_year' => ['required', 'digits:4'],
            'classroom' => ['required'],
            'title' => ['required', 'string'],
            'chapterNo' => ['required', 'numeric'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'academic_year.required' => "يجب عليك ادخال اسم السنة الدراسية",
            'academic_year.digits' => "يجب عليك ادخال اسم السنة الدراسية رقم مثل 2020",
            'classroom.required' => 'يجب عليك اختيار الصف الدراسي',
            'title.required' => "يجب عليك ادخال اسم الفصل",
            'title.string' => "يجب عليك ادخال اسم الفصل احرف",
            'chapterNo.required' => "يجب عليك ادخال رقم الشابتر",
            'chapterNo.digits' => "يجب عليك ادخال رقم الفصل رقم",
        ];
    }
}
