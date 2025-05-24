<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Course $course, Request $request)
    {
        // $query = 
        return $course->exams(); 
        // ->with(['course', 'academicYear']);

        if ($request->has('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $exams = $query->orderBy('created_at', 'desc')->get();
        return ExamResource::collection($exams);
    }
    public function show(Course $course, Exam $exam)
    {
        if ($exam->course_id !== $course->id) {
            return response()->json([
                'message' => 'This exam does not belong to the specified course'
            ], 404);
        }

        $exam->load(['course', 'academicYear']);
        return new ExamResource($exam);
    }
}
