<?php

namespace App\Http\Requests\Admin\Website;

use Illuminate\Foundation\Http\FormRequest;

class EditWelcomeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        foreach ($this->input('id', []) as $id) {
            $sectionId = (int) $id;
            $key = 'images_' . $id;

            if (! is_array($this->input($key))) {
                continue;
            }

            $files = array_values(array_filter($this->input($key)));

            if (websiteSectionIsVideo($sectionId)) {
                $max = websiteSectionVideoMaxFiles($sectionId);
                $files = array_slice($files, 0, $max);
                if ($max === 1) {
                    $single = resolveUploadedFilename($files);
                    $this->merge([$key => $single ? [$single] : []]);
                } else {
                    $this->merge([$key => $files]);
                }
            } else {
                $this->merge([$key => $files]);
            }
        }
    }

    public function rules(): array
    {
        $return = [];

        foreach ($this->request->all()['id'] as $id) {
            $sectionId = (int) $id;
            $return['title_' . $id] = 'required';

            if (websiteSectionIsVideo($sectionId)) {
                $max = websiteSectionVideoMaxFiles($sectionId);
                $return['images_' . $id] = "required|array|min:1|max:{$max}";
            } else {
                $return['images_' . $id] = 'required|array|min:1';
            }
        }

        return $return;
    }

    public function messages(): array
    {
        $return = [];

        foreach ($this->request->all()['id'] as $id) {
            $sectionId = (int) $id;
            $return['title_' . $id . '.required'] = 'يجب ان تدخل عنوان السكشن';

            if (websiteSectionIsVideo($sectionId)) {
                $max = websiteSectionVideoMaxFiles($sectionId);
                $return['images_' . $id . '.required'] = $max === 2
                    ? 'يجب رفع فيديو واحد على الأقل (حد أقصى فيديوهين)'
                    : 'يجب رفع فيديو واحد للسكشن';
                $return['images_' . $id . '.max'] = $max === 2
                    ? 'فيديوهان كحد أقصى لهذا السكشن'
                    : 'فيديو واحد فقط لهذا السكشن';
            } else {
                $return['images_' . $id . '.required'] = 'يجب رفع صورة واحدة على الأقل';
            }
        }

        return $return;
    }
}
