<?php

namespace App\Http\Requests\StudentAccount;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentAccountRequest extends FormRequest
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
            'first_name' => 'sometimes|string|max:255',
            'middle_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|digits:10',
            'linkedIn_account' => 'sometimes|url|nullable',
            'facebook_account' => 'sometimes|url|nullable',
            'github_account' => 'sometimes|url|nullable',
            'x_account' => 'sometimes|url|nullable',
        ];
    }
}
