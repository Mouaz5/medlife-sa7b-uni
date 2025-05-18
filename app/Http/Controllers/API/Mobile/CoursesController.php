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
        $courses = Course::where('collage_id', $collage_id)->with([
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
    public function show_course_by_id($collage_id, $id)
    {
        try {
            $courses = Course::where('collage_id', $collage_id)->where("id", $id)->with([
                'collage.university',
                'semester.academicYear',
                'semester.studyYear'
            ])->first();

            return response()->json(
                ApiFormatter::SendResponses(
                    false,
                    Response::HTTP_OK,
                    'Course Retrieved Successfully',
                    new CourseResource($courses)
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
    public function update(UpdateCourseRequest $request, $id)
    {
        try {
            $current_course = $this->find_course($id);
            if (!$current_course) {
                return response()->json(
                    ApiFormatter::SendResponses(
                        true,
                        Response::HTTP_NOT_FOUND,
                        'Course not found',
                        null
                    ),
                    Response::HTTP_NOT_FOUND
                );
            }

            $validatedData  = $request->validated();

            $is_updated = $current_course->update(
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
    public function destroy($id)
    {
        try {
            $current_course = $this->find_course($id);
            if (!$current_course) {
                return response()->json(
                    ApiFormatter::SendResponses(
                        true,
                        Response::HTTP_NOT_FOUND,
                        'Course not found',
                        null
                    ),
                    Response::HTTP_NOT_FOUND
                );
            }

            $current_course->delete($id);

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
    private function find_course($id)
    {
        return Course::find($id);
    }
}
