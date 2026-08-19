<?php

namespace App\Http\Requests\Admin\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEditStudentManageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (is_array($this->input('avatar'))) {
            $this->merge(['avatar' => $this->input('avatar')[0] ?? null]);
        }
    }

    public function rules(): array
    {
        $studentId = $this->route('id');

        return [
            'center_id' => ['required'],
            'academic_year' => ['required', 'digits:4'],
            'classroom' => ['required'],
            'name' => ['required', 'string', 'min:12'],
            'phone' => [
                'required',
                'digits:11',
                Rule::unique('students')->ignore($studentId),
            ],
            'father_phone' => [
                'required',
                'digits:11',
                Rule::unique('students')->ignore($studentId),
            ],
            'password' => [
                Rule::requiredIf(fn () => $this->routeIs('admin.students.studentManage.create.submit')),
                'nullable',
                'string',
                'min:6',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'center_id.required' => 'يجب ان تختار سنتر',
            'academic_year.required' => 'يجب عليك ادخال اسم السنة الدراسية',
            'academic_year.digits' => 'يجب عليك ادخال اسم السنة الدراسية رقم مثل 2020',
            'classroom.required' => 'يجب ان تختار الصف الدراسي',
            'name.required' => 'يجب عليك ادخال اسم الطالب',
            'name.string' => 'يجب عليك ادخال اسم احرف',
            'name.min' => 'يجب عليك ادخال اسم الطالب ثلاثى',
            'phone.required' => 'يجب عليك ادخال اسم رقم الطالب',
            'phone.digits' => 'يجب عليك ادخال ارقام صحيحة',
            'phone.unique' => 'رقم الطالب تابع لطالب اخر',
            'father_phone.required' => 'يجب عليك ادخال اسم رقم ولى أمر الطالب',
            'father_phone.digits' => 'يجب عليك ادخال رقم ولى أمر ارقام صحيحة',
            'father_phone.unique' => 'رقم ولى امر الطالب تابع لطالب اخر',
            'password.required' => 'يجب ادخال كلمة المرور',
            'password.min' => 'كلمة المرور يجب ان تكون 6 احرف على الاقل',
        ];
    }
}
