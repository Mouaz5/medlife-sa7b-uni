<?php

namespace App\Http\Requests\AcademicGuidance;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicGuidanceRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'content' => 'required|string|min:10',
            'type' => 'required|in:up,down'
        ];
    }
} 