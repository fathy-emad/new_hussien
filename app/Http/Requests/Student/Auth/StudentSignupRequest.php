<?php

namespace App\Http\Requests\Student\Auth;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StudentSignupRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required'],
            'phone' => ["required", "digits:11"],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required'],
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
            'code.required' => "يجب ان تدخل الكود",
            'phone.required' => "يجب ان تدخل رقم الموبايل",
            'phone.digits' => "يجب ان تدخل رقم الموبايل صحيح",
            'password.required' => "يجب ان تدخل كلمة المرور",
            'password.confirmed' => "يجب ان تكون كلمة المرور مطابقة للتأكيد",
            'password.min' => "يجب ان تدخل كلمة المرور 8 حروف او ارقام على الأقل",
            'password_confirmation.required' => "يجب ان تدخل تاكيد كلمة المرور",
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function checkFoundAndNotActive(?Student $student): void
    {
        if (!$student) throw ValidationException::withMessages([ "عفوآ الكود غير صحيح" ]);
        if ($student->password) throw ValidationException::withMessages([ "عفوآ الطالب مسجل بالفعل" ]);
    }
}
