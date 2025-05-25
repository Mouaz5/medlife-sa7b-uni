<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentWithCoursesResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function get_my_course()
    {

        $user = Auth::user();
        if ($user->role !== 'student') {
            return response()->json(
                ApiFormatter::error('Unauthorized', 401)
            );
        }

        $student = Student::with(['courses.collage', 'courses.semester'])
            ->where('user_id', $user->id)
            ->firstOrFail();
        return response()->json(
            ApiFormatter::success(
                'course retrived successfully',
                new StudentWithCoursesResource($student)
            )
        );
    }
}
