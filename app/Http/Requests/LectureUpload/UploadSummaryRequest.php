<?php

namespace App\Http\Requests\LectureUpload;

use Illuminate\Foundation\Http\FormRequest;

class UploadSummaryRequest extends FormRequest
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
            'summaries' => 'required|array|max:5',
            'summaries.*' => 'file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max per file
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
            'summaries.required' => 'At least one summary file is required.',
            'summaries.array' => 'Summaries must be provided as an array.',
            'summaries.max' => 'You can upload a maximum of 5 summary files.',
            'summaries.*.file' => 'Each summary must be a valid file.',
            'summaries.*.mimes' => 'Summary files must be of type: pdf, doc, docx, txt.',
            'summaries.*.max' => 'Each summary file must not exceed 10MB.',
        ];
    }
}
