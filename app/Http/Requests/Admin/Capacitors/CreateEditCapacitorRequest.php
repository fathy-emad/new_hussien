<?php

namespace App\Http\Requests\Admin\Capacitors;

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
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'يجب ان تدخل اسم الدرس',
            'watch_times.required' => 'يجب ان تدخل عدد مرات المشاهدة',
            'watch_times.numeric' => 'يجب ان يكون عدد مرات المشاهدة رقم',
            'classroom.required' => 'يجب ان تختار الصف الدراسي',
        ];
    }
}
