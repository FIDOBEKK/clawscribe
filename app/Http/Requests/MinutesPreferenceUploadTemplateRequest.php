<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MinutesPreferenceUploadTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'template' => [
                'required',
                'file',
                'mimes:pdf,docx,txt,md',
                'max:20480',
            ],
        ];
    }
}
