<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentFollowController extends Controller
{
    public function followStudent(Student $student)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $currentStudent = $user->student;

        if ($currentStudent->id === $student->id) {
            return response()->json([
                'message' => 'You cannot follow yourself.',
            ], 400);
        }

        Follow::create([
            'follower_id' => $currentStudent->id,
            'followed_id' => $student->id,
        ]);

        return response()->json([
            'message' => 'Student Followed Successfully'
        ]);
    }

    public function unfollowStudent(Student $student)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $currentStudent = $user->student;

        if ($currentStudent->id === $student->id) {
            return response()->json([
                'message' => 'You cannot unfollow yourself.',
            ], 400);
        }

        Follow::where('follower_id', $currentStudent->id)
            ->where('followed_id', $student->id)
            ->delete();

        return response()->json([
            'message' => 'Student Unfollowed Successfully'
        ]);
    }

    public function getMyFollowers()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $student = $user->student;

        $followers = $student->followerStudents;

        return response()->json([
            'message' => 'Followers retrieved successfully.',
            'data' => $followers,
        ]);
    }

    public function getMyFollowing()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $student = $user->student;

        $following = $student->followingStudents;


        return response()->json([
            'message' => 'Following retrieved successfully.',
            'data' => $following,
        ]);
    }
}
