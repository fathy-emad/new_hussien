<?php

namespace App\Http\Requests\Admin\Capacitors;

use App\Support\VimeoVideo;
use Illuminate\Foundation\Http\FormRequest;

class CreateEditCapacitorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (is_array($this->link)) {
            $this->merge(['link' => $this->link[0] ?? null]);
        }
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'watch_times' => ['required', 'numeric'],
            'classroom' => ['required'],
            'link' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! VimeoVideo::normalize((string) $value)) {
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
            'watch_times.required' => 'يجب ان تدخل عدد مرات المشاهدة',
            'watch_times.numeric' => 'يجب ان يكون عدد مرات المشاهدة رقم',
            'classroom.required' => 'يجب ان تختار الصف الدراسي',
            'link.required' => 'يجب إدخال فيديو Vimeo',
        ];
    }
}
