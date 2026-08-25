<?php

namespace App\Http\Requests\Admin\Student;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentsCardsRequest extends FormRequest
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
            "count" => "required|integer|min:1|max:5000",
            "title" => "required|string",
            'academic_year' => ['required', 'digits:4'],
            'classroom' => ['required', 'in:1,2,3'],

        ];
    }

    public function messages(): array
    {
        return [
            "count.required" => "العدد مطلوب",
            "count.integer" => "العدد يجب ان يكون رقم",
            "count.min" => "العدد يجب ان يكون 1 على الأقل",
            "count.max" => "العدد الأقصى 5000 كارت في المرة الواحدة",
        ];
    }
}
