<?php

namespace App\Http\Requests\Admin\Website;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWebsitePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string', 'max:5000'],
            'why_us_title' => ['nullable', 'string', 'max:255'],
            'why_us_description' => ['nullable', 'string', 'max:5000'],
            'why_us_points' => ['nullable', 'array', 'size:4'],
            'why_us_points.*' => ['nullable', 'string', 'max:500'],
            'why_us_side_image' => ['nullable', 'array'],
            'why_us_side_image.*' => ['nullable', 'string', 'max:255'],
            'trending_offline_title' => ['nullable', 'string', 'max:255'],
            'trending_offline_description' => ['nullable', 'string', 'max:5000'],
            'featured_students_title' => ['nullable', 'string', 'max:255'],
            'featured_students_description' => ['nullable', 'string', 'max:5000'],
            'featured_students_images' => ['nullable', 'array'],
            'featured_students_images.*' => ['nullable', 'string', 'max:255'],
            'reviews_title' => ['nullable', 'string', 'max:255'],
            'reviews_description' => ['nullable', 'string', 'max:5000'],
            'centers_title' => ['nullable', 'string', 'max:255'],
            'centers_description' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
