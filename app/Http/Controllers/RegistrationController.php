<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Http\Requests\Auth\RequestRegistrationOtpRequest;
use App\Http\Requests\Auth\VerifyOtpAndRegisterRequest;
use App\Mail\RegistrationOtpMail;
use App\Models\User;
use App\Models\Student;
use App\Models\PrivacySetting;
use App\Models\StudentAcademicTimeline;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
class RegistrationController extends Controller
{
    /**
     * Step 1: Request OTP for registration.
     * Stores registration data and sends OTP to the user's email.
     */
    public function requestOtp(RequestRegistrationOtpRequest $request): JsonResponse
    {
        
        $validatedData = $request->validated();

        // Generate OTP
        $otp = (string) random_int(100000, 999999); 
        echo $otp;
        $cacheKey = 'registration_otp_' . $validatedData['email'];
        Cache::put($cacheKey, ['data' => $validatedData, 'otp' => $otp], now()->addMinutes(10));
        
        // Send OTP email (ensure mail is configured)
        try {
            Mail::to($validatedData['email'])->send(new RegistrationOtpMail($otp));
        } catch (\Exception $e) {
            // Log mail sending error if necessary
            return response()->json(ApiFormatter::error('Failed to send OTP email. Please try again.', ['email_error' => $e->getMessage()]), 500);
        }

        return response()->json(ApiFormatter::success('OTP sent to your email successfully. Please verify to complete registration.', [
            'email' => $validatedData['email']
        ]));
    }
    /**
     * Step 2: Verify OTP and complete registration.
     * Creates User, Student, and related records, then returns an API token.
     */
    public function verifyOtpAndRegister(VerifyOtpAndRegisterRequest $request): JsonResponse
    {
        $validatedOtpData = $request->validated();
        $cacheKey = 'registration_otp_' . $validatedOtpData['email'];

        $cachedRegistration = Cache::get($cacheKey);
        
        if (!$cachedRegistration) {
            return response()->json(ApiFormatter::error('Invalid or expired OTP. Please request a new one.', null), 400);
        }

        if ($cachedRegistration['otp'] !== $validatedOtpData['otp']) {
            return response()->json(ApiFormatter::error('Incorrect OTP. Please try again.', null), 400);
        }

        $registrationData = $cachedRegistration['data'];

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

            Cache::forget($cacheKey);

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
}
