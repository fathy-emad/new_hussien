<?php

namespace App\Http\Requests\Student;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function passMatches(): void
    {
        if ($this->request->get('password') != $this->request->get('password_confirmation'))
        {
            throw ValidationException::withMessages([ "عليك التاكد من كلمة المرور و تاكيد كلمة المرور" ]);
        }
    }
}
