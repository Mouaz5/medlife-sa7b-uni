<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicGuidance;
use App\Models\Course;
use App\Models\AcademicGuidanceVote;
use App\Http\Requests\AcademicGuidance\StoreAcademicGuidanceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class AcademicGuidanceController extends Controller
{


    // Student can view all their academic guidance entries
    public function index(Request $request): JsonResponse
    {
        $student = $request->user()->student;
        
        $guidanceEntries = AcademicGuidance::with(['course', 'votes'])
            ->where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $guidanceEntries
        ]);
    }



    //Student can add academic guidance for a specific course
    public function store(StoreAcademicGuidanceRequest $request): JsonResponse
    {
        $student = $request->user()->student;
        
        $guidance = AcademicGuidance::create([
            'student_id' => $student->id,
            'course_id' => $request->course_id,
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

    // Student can modify their own academic guidance
    public function update(Request $request, AcademicGuidance $academicGuidance): JsonResponse
    {
        // Check if the guidance belongs to the authenticated student
        if ($academicGuidance->student_id !== $request->user()->student->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to modify this guidance'
            ], 403);
        }

        $request->validate([
            'content' => 'required|string|min:10',
            'type' => 'required|in:up,down'
        ]);

        $academicGuidance->update([
            'content' => $request->content,
            'type' => $request->type
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Academic guidance updated successfully',
            'data' => $academicGuidance
        ]);
    }

    // Student can delete their own academic guidance
    public function destroy(Request $request, AcademicGuidance $academicGuidance): JsonResponse
    {
        // Check if the guidance belongs to the authenticated student
        if ($academicGuidance->student_id !== $request->user()->student->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to delete this guidance'
            ], 403);
        }

        $academicGuidance->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Academic guidance deleted successfully'
        ]);
    }

    // Student can view all academic guidance for a specific course
    public function getCourseGuidance(Request $request, Course $course): JsonResponse
    {
        $query = AcademicGuidance::with(['student', 'votes'])
            ->where('course_id', $course->id);

        // Filter by type if provided
        if ($request->has('type')) {
            $request->validate([
                'type' => 'required|in:up,down'
            ]);
            $query->where('type', $request->type);
        }

        $guidanceEntries = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $guidanceEntries
        ]);
    }

    // Student can filter guidance by type
    public function filterByType(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:up,down'
        ]);

        $guidanceEntries = AcademicGuidance::with(['student', 'course', 'votes'])
            ->where('type', $request->type)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $guidanceEntries
        ]);
    }

    // Student can filter guidance by date
    public function filterByDate(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        
        $guidanceEntries = AcademicGuidance::with(['student', 'course', 'votes'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $guidanceEntries
        ]);
    }

    // Student can upvote/downvote academic guidance
    public function vote(Request $request, AcademicGuidance $academicGuidance): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:up,down'
        ]);

        $student = $request->user()->student;

        // Check if student has already voted
        $existingVote = AcademicGuidanceVote::where('student_id', $student->id)
            ->where('academic_guidance_id', $academicGuidance->id)
            ->first();

        if ($existingVote) {
            // If voting the same type, remove the vote
            if ($existingVote->type === $request->type) {
                $existingVote->delete();
                $academicGuidance->decrement('vote_count');
                return response()->json([
                    'status' => 'success',
                    'message' => 'Vote removed successfully'
                ]);
            }
            // If voting different type, update the vote
            $existingVote->update(['type' => $request->type]);
            return response()->json([
                'status' => 'success',
                'message' => 'Vote updated successfully'
            ]);
        }

        // Create new vote
        AcademicGuidanceVote::create([
            'student_id' => $student->id,
            'academic_guidance_id' => $academicGuidance->id,
            'type' => $request->type
        ]);

        $academicGuidance->increment('vote_count');

        return response()->json([
            'status' => 'success',
            'message' => 'Vote added successfully'
        ]);
    }

    // Get vote statistics for a specific academic guidance
    public function getVoteStats(AcademicGuidance $academicGuidance): JsonResponse
    {
        $upvotes = $academicGuidance->votes()->where('type', 'up')->count();
        $downvotes = $academicGuidance->votes()->where('type', 'down')->count();
        $totalVotes = $upvotes + $downvotes;
        
        $stats = [
            'total_votes' => $totalVotes,
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
            'upvote_percentage' => $totalVotes > 0 ? round(($upvotes / $totalVotes) * 100, 2) : 0,
            'downvote_percentage' => $totalVotes > 0 ? round(($downvotes / $totalVotes) * 100, 2) : 0
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }
} 