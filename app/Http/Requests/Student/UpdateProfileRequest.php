<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'رقم الموبايل مطلوب.',
            'phone.digits' => 'رقم الموبايل يجب أن يتكون من 11 رقماً.',
            'phone.unique' => 'رقم الموبايل مستخدم بواسطة طالب آخر.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function passMatches(): void
    {
        if ($this->request->get('password') != $this->request->get('password_confirmation'))
        {
            throw ValidationException::withMessages([ "عليك التاكد من كلمة المرور و تاكيد كلمة المرور" ]);
        }
    }
}
