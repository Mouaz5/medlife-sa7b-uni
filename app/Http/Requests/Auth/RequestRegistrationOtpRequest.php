<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RequestRegistrationOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Anyone can attempt to request an OTP for registration
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'study_year_id' => 'required|integer|exists:study_years,id',
            'college_id' => 'required|integer|exists:colleges,id',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ];
    }
}
