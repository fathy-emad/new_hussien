<?php

namespace App\Http\Requests\Admin\PermissionsAndEmployees;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditPermissionRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:4'],
            'permissions' => ['required'],
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
            'title.required' => __('validation.required'),
            'title.string' => __('validation.string'),
            'title.min' => __('validation.min'),
            'permissions' => __('validation.permissions'),
        ];
    }
}
