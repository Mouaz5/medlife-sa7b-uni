<?php

namespace App\Http\Controllers\API\Mobile;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CoursesController extends Controller
{
    public function getAllCourses($collage_id)
    {
        $courses = Course::where('college_id', $collage_id)->with([
            'collage.university',
            'semester.academicYear',
            'semester.studyYear'
        ])->get();
        return response()->json(
            ApiFormatter::SendResponses(
                false,
                Response::HTTP_OK,
                'Courses Retrieved Successfully',
                CourseResource::collection($courses)
            ),
            Response::HTTP_OK
        );
    }
    public function store_course(StoreCourseRequest $request)
    {
        try {
            $validatedData  = $request->validated();
            Course::create(
                $validatedData
            );
            return response()->json(
                ApiFormatter::SendResponses(
                    false,
                    Response::HTTP_CREATED,
                    'course stored successfully',
                    null
                ),
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return response()->json(
                ApiFormatter::SendResponses(
                    true,
                    Response::HTTP_BAD_REQUEST,
                    $e->getMessage(),
                    null
                ),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
    public function show_course_by_id(Course $course)
    {
        try {
            return response()->json(
                ApiFormatter::SendResponses(
                    false,
                    Response::HTTP_OK,
                    'Course Retrieved Successfully',
                    new CourseResource(
                        $course->load(['collage.university', 'semester.academicYear', 'semester.studyYear'])
                    )
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return response()->json(
                ApiFormatter::SendResponses(
                    true,
                    Response::HTTP_BAD_REQUEST,
                    $e->getMessage(),
                    null
                ),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {

            $validatedData  = $request->validated();

            $course->update(
                $validatedData
            );
            return response()->json(
                ApiFormatter::SendResponses(
                    false,
                    Response::HTTP_CREATED,
                    'course updated successfully',
                    null
                ),
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return response()->json(
                ApiFormatter::SendResponses(
                    true,
                    Response::HTTP_BAD_REQUEST,
                    $e->getMessage(),
                    null
                ),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
    public function destroy(Course $course)
    {
        try {
            $course->delete();
            return response()->json(
                ApiFormatter::SendResponses(
                    false,
                    Response::HTTP_OK,
                    'course deleted successfully',
                    null
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return response()->json(
                ApiFormatter::SendResponses(
                    true,
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    'Error deleting policy',
                    null
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
