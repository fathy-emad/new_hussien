<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginRequest extends FormRequest
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
            'email' => ['required', "email"],
            'password' => ['required'],
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
            'email.required' => __('validation.required'),
            'password.required' => __('validation.required'),
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
            'email' => $this->input('email'),
            'password' => $this->input('password'),
        ];

        if (! Auth::guard($guard)->attempt($credentials, $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => [__('validation.credentialsFailed')],
            ]);
        }
    }
}
