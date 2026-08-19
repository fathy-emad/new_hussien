<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEditScheduleRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {

        $academic_year = $this->request->get('academic_year');
        $classroom = $this->request->get('classroom');
        $center_id = $this->request->get('center_id');
        $day = $this->request->get('day');
        $from = $this->request->get('from');
        $from_type = $this->request->get('from_type');

        return [
            'academic_year' => ['required', 'digits:4'],
            'classroom' => ['required'],
            'center_id' => ['required'],
            'day' => ['required',
                Rule::unique('schedules')->where(function ($query) use($academic_year, $classroom, $center_id, $day, $from, $from_type) {
                    return $query->where('academic_year', $academic_year)
                        ->where('classroom', $classroom)->where('center_id', $center_id)
                        ->where('day', $day)->where('from', $from)->where('from_type', $from_type)
                        ->where('canceled', '0')->orWhere('canceled', '2');
                })->ignore($this->route('id'), 'id')
            ],
            'from' => ['required'],
            'to' => ['required'],
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
            'academic_year.required' => "يجب عليك ادخال اسم السنة الدراسية",
            'academic_year.digits' => "يجب عليك ادخال اسم السنة الدراسية رقم مثل 2020",
            'classroom.required' => "يجب عليك إختيار المرحلة الدراسية",
            'center_id.required' => "يجب عليك إختيار السنتر",
            'day.required' => "يجب عليك إختيار يوم الحصة",
            'day.unique' => "هذا الميعاد مشغول قم بمراجعة الاوقات الفارغة مرة اخرى",
            'from.required' => "يجب عليك ادخال وقت بداية الحصة",
            'to.required' => "يجب عليك ادخال وقت إانتهاء الحصة",
        ];
    }
}
