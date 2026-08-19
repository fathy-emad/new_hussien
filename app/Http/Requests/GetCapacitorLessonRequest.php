<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCapacitorLessonRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "lesson_id" => 'required|integer|exists:capacitors,id',
            "code" => "required|exists:capacitor_cards,code",
        ];
    }

    public function messages(): array
    {
        return [
            "lesson_id.required" => 'يرجى اختيار الدرس',
            "lesson_id.exists" => 'هذا الدرس غير موجود',
            "code.required" => 'يرجى إدخال الكود',
            "code.exists" => 'كود الكارت غير صحيح',
        ];
    }



    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new \Illuminate\Http\JsonResponse([
            'success' => false,
            'errors' => $validator->errors()
        ], 422); // 422 Unprocessable Entity

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
