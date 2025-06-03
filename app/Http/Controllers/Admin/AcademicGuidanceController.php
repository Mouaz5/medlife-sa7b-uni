<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicGuidance;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AcademicGuidanceController extends Controller
{
    /**
     * Admin can add academic guidance for a specific course
     *
     * @param Request $request
     * @param Course $course
     * @return JsonResponse
     */
    public function store(Request $request, Course $course): JsonResponse
    {
        $request->validate([
            'content' => 'required|string|min:10',
            'type' => 'required|in:up,down',
            'student_id' => 'required|exists:students,id'
        ]);

        $guidance = AcademicGuidance::create([
            'student_id' => $request->student_id,
            'course_id' => $course->id,
            'content' => $request->content,
            'type' => $request->type,
            'vote_count' => 0
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Academic guidance created successfully',
            'data' => $guidance
        ], 201);
    }

    /**
     * Admin can delete academic guidance for a specific course
     *
     * @param AcademicGuidance $academicGuidance
     * @return JsonResponse
     */
    public function destroy(AcademicGuidance $academicGuidance): JsonResponse
    {
        $academicGuidance->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Academic guidance deleted successfully'
        ]);
    }
} 