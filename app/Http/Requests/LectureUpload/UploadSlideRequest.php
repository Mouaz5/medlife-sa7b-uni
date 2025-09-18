<?php

namespace App\Http\Requests\LectureUpload;

use Illuminate\Foundation\Http\FormRequest;

class UploadSlideRequest extends FormRequest
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
            'slides' => 'required|array|max:10',
            'slides.*' => 'file|mimes:pdf,ppt,pptx,doc,docx,jpg,jpeg,png|max:10240', // 10MB max per file
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
            'slides.required' => 'At least one slide file is required.',
            'slides.array' => 'Slides must be provided as an array.',
            'slides.max' => 'You can upload a maximum of 10 slide files.',
            'slides.*.file' => 'Each slide must be a valid file.',
            'slides.*.mimes' => 'Slide files must be of type: pdf, ppt, pptx, doc, docx, jpg, jpeg, png.',
            'slides.*.max' => 'Each slide file must not exceed 10MB.',
        ];
    }
}
