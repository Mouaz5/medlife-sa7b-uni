<?php

namespace App\Http\Controllers\API\Mobile;

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
            ApiFormatter::SendResponses(
                false,
                Response::HTTP_CREATED,
                'lectures index successfully',
                LectureResource::collection($lectures)
            ),
            Response::HTTP_CREATED
        );
    }


    public function show(Course $course, Lecture $lecture)
    {
        if ($lecture->course_id !== $course->id) {

            return response()->json(
                ApiFormatter::SendResponses(
                    true,
                    Response::HTTP_NOT_FOUND,
                    'This lecture does not belong to the specified course',
                    null
                ),
                Response::HTTP_NOT_FOUND
            );
        }

        $lecture->load(['course', 'academicYear', 'files']);

        return;
        return response()->json(
            ApiFormatter::SendResponses(
                false,
                Response::HTTP_OK,
                'lecture retrived successfully ... ',
                new LectureResource($lecture)
            ),
            Response::HTTP_OK
        );
    }
}
