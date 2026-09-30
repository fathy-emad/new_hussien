<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = auth('student')->id();

        return [
            'phone' => [
                'required',
                'digits:11',
                Rule::unique('students', 'phone')->ignore($studentId),
            ],
            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
            'password_confirmation' => [
                'nullable',
                'required_with:password',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'رقم الموبايل مطلوب.',
            'phone.digits' => 'رقم الموبايل يجب أن يتكون من 11 رقماً.',
            'phone.unique' => 'رقم الموبايل مستخدم بواسطة طالب آخر.',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 6 أحرف.',
            'password.confirmed' => 'كلمة المرور وتأكيد كلمة المرور غير متطابقين.',
            'password_confirmation.required_with' => 'تأكيد كلمة المرور مطلوب عند إدخال كلمة مرور جديدة.',
        ];
    }
}
