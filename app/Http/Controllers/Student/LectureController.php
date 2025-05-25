<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LectureController extends Controller
{
    public function index(Course $course)
    {
        $lectures = $course->lectures()
            ->with(['course', 'academicYear', 'files'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(
            ApiFormatter::success(
                'lectures index successfully',
                LectureResource::collection($lectures)
            )
        );
    }


    public function show(Course $course, Lecture $lecture)
    {
        if ($lecture->course_id !== $course->id) {

            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $lecture->load(['course', 'academicYear', 'files']);

        return;
        return response()->json(
            ApiFormatter::success(
                'lecture retrived successfully ... ',
                new LectureResource($lecture)
            )
        );
    }
}
