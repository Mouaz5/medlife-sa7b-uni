<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentWithCoursesResource;
use App\Models\Course;
use App\Models\StudentCourse;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::get()->map(function ($course) {
            return [
                'id' => $course->id,
                'course_name' => $course->name,
            ];
        });
        return response()->json(
            ApiFormatter::success(
                'courses retrived successfully',
                $courses
            )
        );
    }
    // there is student_courses pivot table could you help me edit the function ?
    public function myCourses() {
        $student = auth()->user()->student;
        $courses = $student->courses()->get()->map(function ($course){
            return [
                'id' => $course->id,
                'course_name' => $course->name,
            ];
        });
        return response()->json(
            ApiFormatter::success(
                'my courses retrived successfully',
                $courses
            )
        );
    }
    public function show(Course $course) {
        $course->load('lectures', 'handouts', 'academicGuidance', 'events', 'exams', 'announcements');
        return response()->json(
            ApiFormatter::success(
                'course details retrived successfully',
                new CourseResource($course)
            )
        );
    }   

}
