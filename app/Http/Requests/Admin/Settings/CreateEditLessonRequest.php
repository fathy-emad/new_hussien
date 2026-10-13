<?php

namespace App\Http\Requests\Admin\Settings;

use App\Support\VimeoVideo;
use Illuminate\Foundation\Http\FormRequest;

class CreateEditLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        foreach (['link'] as $field) {
            if (is_array($this->input($field))) {
                $this->merge([$field => $this->input($field)[0] ?? null]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'chapter_id' => ['required'],
            'NO' => ['required', 'numeric'],
            'watchTimes' => ['required', 'numeric', 'min:0'],
            'link' => [
                'nullable',
                'string',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (trim((string) $value) !== '' && ! VimeoVideo::normalize((string) $value)) {
                        $fail('أدخل رقم فيديو Vimeo أو رابط/كود embed صحيح.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'يجب ان تدخل اسم الدرس',
            'chapter_id.required' => 'يجب ان تختار فصل',
            'NO.required' => 'يجب ان تدخل رقم الدرس',
            'NO.numeric' => 'يجب ان تدخل رقم الدرس رقم',
            'watchTimes.required' => 'يجب ان تدخل عدد مرات المشاهدة',
            'watchTimes.numeric' => 'يجب ان تدخل عدد مرات المشاهدة رقم',
        ];
    }
}
