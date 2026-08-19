<?php

namespace App\Http\Requests\Student;

use App\Models\WebsiteReview;
use Illuminate\Foundation\Http\FormRequest;

class StoreWebsiteReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('student')->check();
    }

    public function rules(): array
    {
        return [
            'body' => ['required', 'string', 'min:'.WebsiteReview::BODY_MIN, 'max:'.WebsiteReview::BODY_MAX],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'يرجى كتابة رأيك.',
            'body.min' => 'يجب أن يكون الرأي '.WebsiteReview::BODY_MIN.' أحرف على الأقل.',
            'body.max' => 'الرأي طويل جداً. الحد الأقصى '.WebsiteReview::BODY_MAX.' حرفاً ليتناسب مع عرض الموقع.',
        ];
    }
}
