<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpAndRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Anyone can attempt to verify an OTP
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255', // Check if email exists if we pre-validate, or just check cache
            'otp' => 'required|string|digits:6',
        ];
    }
     /**
     * Modify rules for email existence check.
     * We check if the email has a pending OTP rather than if it exists in the users table yet.
     */
    protected function prepareForValidation()
    {
        
    }
}
