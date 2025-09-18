<?php

namespace App\Http\Requests\Complaint;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
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
            'title' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10|max:2000',
            'type_id' => 'required|exists:complaint_types,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max per image
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
            'title.required' => 'The complaint title is required.',
            'title.min' => 'The complaint title must be at least 5 characters.',
            'title.max' => 'The complaint title must not exceed 255 characters.',
            'description.required' => 'The complaint description is required.',
            'description.min' => 'The complaint description must be at least 10 characters.',
            'description.max' => 'The complaint description must not exceed 2000 characters.',
            'type_id.required' => 'Please select a complaint type.',
            'type_id.exists' => 'The selected complaint type is invalid.',
            'images.array' => 'Images must be provided as an array.',
            'images.max' => 'You can upload a maximum of 5 images.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Images must be of type: jpeg, png, jpg, gif.',
            'images.*.max' => 'Each image must not exceed 5MB.',
        ];
    }
}
