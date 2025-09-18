<?php

namespace App\Http\Requests\LectureUpload;

use Illuminate\Foundation\Http\FormRequest;

class UploadAudioRequest extends FormRequest
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
            'audios' => 'required|array|max:5',
            'audios.*' => 'file|mimes:mp3,wav,m4a,aac,ogg|max:51200', // 50MB max per file
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
            'audios.required' => 'At least one audio file is required.',
            'audios.array' => 'Audios must be provided as an array.',
            'audios.max' => 'You can upload a maximum of 5 audio files.',
            'audios.*.file' => 'Each audio must be a valid file.',
            'audios.*.mimes' => 'Audio files must be of type: mp3, wav, m4a, aac, ogg.',
            'audios.*.max' => 'Each audio file must not exceed 50MB.',
        ];
    }
}
