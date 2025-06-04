<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function followStudent(Student $student)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $currentStudent = $user->student;

        if ($currentStudent->id === $student->id) {
            return response()->json(
                ApiFormatter::error('You cannot follow yourself.')
            );
        }

        Follow::create([
            'follower_id' => $currentStudent->id,
            'followed_id' => $student->id,
        ]);

        return response()->json(
            ApiFormatter::success('Student Followed Successfully')
        );
    }

    public function unfollowStudent(Student $student)
    {
        $user = Auth::user();

        $currentStudent = $user->student;

        if ($currentStudent->id === $student->id) {
            return response()->json(
                ApiFormatter::error('You cannot unfollow yourself.')
            );
        }

        Follow::where('follower_id', $currentStudent->id)
            ->where('followed_id', $student->id)
            ->delete();

        return response()->json(
            ApiFormatter::success('Student Unfollowed Successfully')
        );
    }

    public function index()
    {
        $user = Auth::user();

        $student = $user->student;

        $followers = $student->followerStudents;

        return response()->json(
            ApiFormatter::success('Followers retrieved successfully.', $followers)
        );
    }

    public function getMyFollowing()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $student = $user->student;

        $following = $student->followingStudents;


        return response()->json(
            ApiFormatter::success('Following retrieved successfully.', $following)
        );
    }
}
