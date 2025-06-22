<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompleteRegistrationRequest;
use App\Http\Requests\Auth\RequestOTPForLoginRequest;
use App\Http\Requests\Auth\RequestOTPForRegistrationRequest;
use App\Http\Requests\Auth\VerifyOTPRequest;
use App\Models\AcademicYear;
use App\Models\College;
use App\Models\Course;
use App\Models\PrivacySetting;
use App\Models\Semester;
use App\Models\Specialization;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function requestOTPForRegistration(RequestOTPForRegistrationRequest $request)
    {
        $request->validated();
        $otp = OtpService::generateOtp($request->email, 'register');
        
        // For testing purposes, include the OTP in the response
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'otp sent',
            'debug_otp' => $otp // This is for testing only
        ]);
    }

    public function verifyOTPForRegistration(VerifyOTPRequest $request)
    {
        $verified = OtpService::verifyOtp($request->email, 'register', $request->otp);
        if (!$verified) {
            return response()->json(
                ApiFormatter::error('OTP Verification Failed')
            );
        }
        OtpService::clearOtp($request->email, 'register');
        return response()->json(
            ApiFormatter::success('OTP verified successfully. Please continue with registration.')
        );
    }

    public function completeRegistration(CompleteRegistrationRequest $request)
    {
        $registrationData = $request->validated();
        DB::beginTransaction();
        try {
            // Create User
            $user = User::create([
                'username' => $registrationData['first_name'] . ' ' . $registrationData['last_name'],
                'email' => $registrationData['email'],
                'password' => Hash::make($registrationData['password']),
                'email_verified_at' => now(),
                'role' => 'student',
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'first_name' => $registrationData['first_name'],
                'last_name' => $registrationData['last_name'],
                'college_id' => $registrationData['college_id'],
            ]);

            PrivacySetting::create([
                'student_id' => $student->id,
                'show_posts' => true,
                'profile_visibility' => 'public',
            ]);

            $currentAcademicYear = AcademicYear::orderBy('year', 'desc')->first();
            if (!$currentAcademicYear) {
                 DB::rollBack();
                return response()->json(ApiFormatter::error('Academic year not found. Cannot complete registration.', null), 500);
            }

            // StudentAcademicTimeline::create([
            //     'student_id' => $student->id,
            //     'study_year_id' => $registrationData['study_year_id'],
            //     'specialization_id' => $registrationData['specialization_id'],
            //     'academic_year_id' => $currentAcademicYear->id,
            // ]);

            DB::commit();


            $token = $user->createToken('api-token-' . Str::slug($user->name))->plainTextToken;

            return response()->json(ApiFormatter::success('Registration successful. Welcome!', [
                'user' => $user->load('student'), // Load student relationship
                'token_type' => 'Bearer',
                'access_token' => $token,
            ]), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(ApiFormatter::error('Registration failed. Please try again later.', ['server_error' => $e->getMessage()]), 500);
        }
    }

    public function requestOTPForLogin(RequestOTPForLoginRequest $request)
    {
        $request->validated();
        OtpService::generateOtp($request->email, 'login');
        return response()->json(
            ApiFormatter::success('otp sent, check your email')
        );
    }

    public function verifyOTPForLogin(VerifyOTPRequest $request)
    {
        $verified = OtpService::verifyOtp($request->email, 'login', $request->otp);
        if (!$verified) {
            return response()->json(
                ApiFormatter::error('OTP Verification Failed')
            );
        }
        OtpService::clearOtp($request->email, 'login');

        $user = Student::where('email', $request->email)->firstOrFail()->user;

        $token = $user->createToken('login_token')->plainTextToken;

        return response()->json(
            ApiFormatter::success('OTP verified successfully', $token)
        );
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(
            ApiFormatter::success('Logged out successfully')
        );
    }
    public function loginTest(Request $request) {
        $credentials = $request->only('email', 'password');
        
        $request->validate([
            'password' => 'required|min:8',
        ]);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken($user->role)->plainTextToken;
            return response()->json(
                ApiFormatter::success('Logged in successfully', $token)
            );
        } else {
            return response()->json(
                ApiFormatter::error('Invalid credentials')
            );
        }
    }
}
