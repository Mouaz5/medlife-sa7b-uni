<?php

namespace App\Http\Requests\LectureUpload;

use Illuminate\Foundation\Http\FormRequest;

class UploadHandoutRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'handouts' => 'required|array|max:10',
            'handouts.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt|max:10240', // 10MB max per file
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title must not exceed 255 characters.',
            'handouts.required' => 'At least one handout file is required.',
            'handouts.array' => 'Handouts must be provided as an array.',
            'handouts.max' => 'You can upload a maximum of 10 handout files.',
            'handouts.*.file' => 'Each handout must be a valid file.',
            'handouts.*.mimes' => 'Handout files must be of type: pdf, doc, docx, ppt, pptx, xls, xlsx, txt.',
            'handouts.*.max' => 'Each handout file must not exceed 10MB.',
        ];
    }
}
