<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentWithCoursesResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StudentCourseController extends Controller
{
    public function get_my_course()
    {

        $user = Auth::user();
        if ($user->role !== 'student') {
            return response()->json(
                ApiFormatter::SendResponses(
                    true,
                    Response::HTTP_FORBIDDEN,
                    "Unauthorized",
                    null
                ),
                Response::HTTP_FORBIDDEN
            );
        }

        $student = Student::with(['courses.collage', 'courses.semester'])
            ->where('user_id', $user->id)
            ->firstOrFail();
        return response()->json(
            ApiFormatter::SendResponses(
                false,
                Response::HTTP_OK,
                'course retrived successfully',
                new StudentWithCoursesResource($student)
            ),
            Response::HTTP_OK
        );
    }
}
