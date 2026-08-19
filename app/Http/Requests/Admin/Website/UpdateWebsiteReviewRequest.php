<?php

namespace App\Http\Requests\Admin\Website;

use App\Models\WebsiteReview;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWebsiteReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            'body.required' => 'يرجى كتابة نص الرأي.',
            'body.min' => 'يجب أن يكون الرأي '.WebsiteReview::BODY_MIN.' أحرف على الأقل.',
            'body.max' => 'الرأي طويل جداً. الحد الأقصى '.WebsiteReview::BODY_MAX.' حرفاً ليتناسب مع عرض الموقع.',
        ];
    }
}
