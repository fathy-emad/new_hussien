<?php

namespace App\Http\Requests\Admin\Capacitors;

use Illuminate\Foundation\Http\FormRequest;

class CreateCardsRequest extends FormRequest
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
            "count" => "required|integer",
            "title" => "required|string"
        ];
    }

    public function messages(): array
    {
        return [
            "count.required" => "العدد مطلوب",
            "count.integer" => "العدد يجب ان يكون رقم"
        ];
    }
}
