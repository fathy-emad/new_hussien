<?php

namespace App\Http\Requests\Admin\Settings;

use App\Models\Center;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEditCenterRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->has('title')) {
            $this->merge([
                'title' => trim($this->title),
            ]);
        }
    }
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
        $titleRules = ['required', 'string', 'min:4'];

        if ($this->routeIs('admin.settings.center.update')) {
            $centerId = $this->input('center_id') ?? $this->route('id');
            $existing = $centerId ? Center::find($centerId) : null;

            // Same title as before: allow save without unique check
            if ($existing && trim($existing->title) === trim((string) $this->input('title'))) {
                return ['title' => $titleRules];
            }

            if ($centerId) {
                $titleRules[] = Rule::unique('centers', 'title')->ignore($centerId, 'id');
            }
        } else {
            $titleRules[] = Rule::unique('centers', 'title');
        }

        return [
            'title' => $titleRules,
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
            'title.required' => 'يجب عليك ادخال اسم السنتر',
            'title.min' => 'اسم السنتر يجب أن يكون 4 أحرف على الأقل',
            'title.unique' => 'اسم السنتر مستخدم بالفعل، يرجى اختيار اسم آخر',
        ];
    }
}
