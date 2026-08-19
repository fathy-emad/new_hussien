<?php

namespace App\Http\Requests\Student\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StudentLoginRequest extends FormRequest
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
            //'phone' => ["required"],
            'password' => ['required']
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
            //'phone.required' => "يجب ان تدخل رقم الموبايل",
            'password.required' => "يجب ان تدخل كلمة المرور",
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(string $guard): void
    {
        $credentials = [
            'code' => $this->input('code'),
            'password' => $this->input('password'),
        ];

        if (! Auth::guard($guard)->attempt($credentials, $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'code' => ['الكود أو كلمة المرور غير صحيحة.'],
            ]);
        }
    }
}
