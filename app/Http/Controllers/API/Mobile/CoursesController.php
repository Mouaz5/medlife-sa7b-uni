<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function getAllCourses(Request $request)
    {
        $courses = Course::where('collage_id', $request->id)->get();

        return response()->json([
            'message' => 'Course Retrieved Successfully',
            'data' => $courses
        ], 200);
    }
}
