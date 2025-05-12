<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudyYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TestController extends Controller
{
    /**
     * Get all courses for a specific study year.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCoursesByStudyYear(Request $request)
    {
        
        $request->validate([
            'year' => 'required|string',
        ]);

        $studyYearName = $request->input('year');
        
        $studyYear = StudyYear::where('year', $studyYearName)
            ->with(['students.courses'])
            ->first();
        
        if (!$studyYear) {
            return Response::json(['message' => 'Study year not found.'], 404);
        }

        $courses = $studyYear->students->flatMap(function ($student) {
            return $student->courses;
        })->unique('id')->values();

        return Response::json($courses);
    }
}
