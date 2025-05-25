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
use App\Models\StudentAcademicTimeline;
use App\Models\StudentCourse;
use App\Models\StudyYear;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiFormatter;

class AuthController extends Controller
{
    public function requestOTPForRegistration(RequestOTPForRegistrationRequest $request)
    {
        $request->validated();
        $otp = OtpService::generateOtp($request->email, 'register');
        return response()->json(
            ApiFormatter::success('otp sent')
        );
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
        $user = User::create([
            'username' => $request->first_name . '_' . $request->last_name . '_' . $request->phone_number,
            'role' => 'student',
            'email' => $request->email,
            'password' => null,
        ]);

        $college = College::where('name', $request->college)->first();
        $study_year = StudyYear::where('year', $request->study_year)
            ->where('college_id', $college->id)
            ->first();

        $academic_year = AcademicYear::where('year', date('Y'))->first();
        $specialization = Specialization::where('name', $request->specialization)->first();

        $semesters = Semester::where('study_year_id', $study_year->id)
            ->where('academic_year_id', $academic_year->id)
            ->get();

        $semesters_ids = $semesters->pluck('id');

        $year_courses = Course::whereIn('semester_id', $semesters_ids)
            ->where('college_id', $college->id)
            ->get();

        $student = Student::create(array_merge($request->validated(), [
            'user_id' => $user->id,
            'college_id' => $college->id
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

        return response()->json(
            ApiFormatter::success('Registration Completed Successfully')
        );
    }

    public function requestOTPForLogin(RequestOTPForLoginRequest $request)
    {
        $request->validated();
        $otp = OtpService::generateOtp($request->email, 'login');
        return response()->json(
            ApiFormatter::success('otp sent')
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
            ApiFormatter::success('OTP verified successfully')
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
}
