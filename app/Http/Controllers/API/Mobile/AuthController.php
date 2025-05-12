<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompleteRegistrationRequest;
use App\Http\Requests\Auth\RequestOTPForLoginRequest;
use App\Http\Requests\Auth\RequestOTPForRegistrationRequest;
use App\Http\Requests\Auth\VerifyOTPRequest;
use App\Models\AcademicYear;
use App\Models\Collage;
use App\Models\Course;
use App\Models\PrivacySetting;
use App\Models\Semester;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\StudentAcademicTimeline;
use App\Models\StudentCourse;
use App\Models\StudyYear;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function requestOTPForRegistration(RequestOTPForRegistrationRequest $request)
    {
        $request->validated();
        $otp = OtpService::generateOtp($request->phone_number, 'register');
        return response()->json([
            'message' => "OTP Sent",
            'otp' => 'for testing purposes only -- this is the otp ' . $otp
        ], 200);
    }

    public function verifyOTPForRegistration(VerifyOTPRequest $request)
    {
        $verified = OtpService::verifyOtp($request->phone_number, 'register', $request->otp);
        if (!$verified) {
            return response()->json([
                'message' => 'OTP Verification Failed'
            ], 400);
        }
        OtpService::clearOtp($request->phone_number, 'register');
        return response()->json([
            'message' => 'OTP verified successfully. Please continue with registration.'
        ], 200);
    }

    public function completeRegistration(CompleteRegistrationRequest $request)
    {
        $user = User::create([
            'username' => $request->first_name . '_' . $request->last_name . '_' . $request->phone_number,
            'role' => 'student',
            'email' => null,
            'password' => null,
        ]);

        $college = Collage::where('name', $request->college)->first();
        $study_year = StudyYear::where('year', $request->study_year)
            ->where('collage_id', $college->id)
            ->first();

        $academic_year = AcademicYear::where('year', date('Y'))->first();
        $specialization = Specialization::where('name', $request->specialization)->first();

        $semesters = Semester::where('study_year_id', $study_year->id)
            ->where('academic_year_id', $academic_year->id)
            ->get();

        $semesters_ids = $semesters->pluck('id');

        $year_courses = Course::whereIn('semester_id', $semesters_ids)
            ->where('collage_id', $college->id)
            ->get();

        $student = Student::create(array_merge($request->validated(), [
            'user_id' => $user->id,
            'collage_id' => $college->id
        ]));

        $chosen_courses = $request->courses;
        $year_course_ids = $year_courses->pluck('id')->toArray();
        $all_courses = array_unique(array_merge($year_course_ids, $chosen_courses));
        foreach ($all_courses as $course_id) {
            StudentCourse::create([
                'student_id' => $student->id,
                'course_id' => $course_id
            ]);
        }

        PrivacySetting::create(['student_id' => $student->id]);
        StudentAcademicTimeline::create([
            'study_year_id' => $study_year->id,
            'student_id' => $student->id,
            'specialization_id' => $specialization->id,
            'academic_year_id' => $academic_year->id
        ]);

        $token = $user->createToken('register_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration Completed Successfully',
            'data' => $token
        ], 200);
    }

    public function requestOTPForLogin(RequestOTPForLoginRequest $request)
    {
        $request->validated();
        $otp = OtpService::generateOtp($request->phone_number, 'login');
        return response()->json([
            'message' => "OTP Sent",
            'otp' => 'for testing purposes only -- this is the otp ' . $otp
        ], 200);
    }

    public function verifyOTPForLogin(VerifyOTPRequest $request)
    {
        $verified = OtpService::verifyOtp($request->phone_number, 'login', $request->otp);
        if (!$verified) {
            return response()->json([
                'message' => 'OTP Verification Failed'
            ], 400);
        }
        OtpService::clearOtp($request->phone_number, 'login');

        $user = Student::where('phone_number', $request->phone_number)->firstOrFail()->user;

        $token = $user->createToken('login_token')->plainTextToken;

        return response()->json([
            'message' => 'OTP verified successfully',
            'data' => $token
        ], 200);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
