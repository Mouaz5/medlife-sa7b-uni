<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentSkills\AddStudentSkill;
use App\Models\Skill;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentSkillsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $student = $user->student;

        $skills = Skill::where('student_id', $student->id)->get();

        return response()->json([
            'message' => 'Skills retrieved successfully.',
            'data' => $skills,
        ], 200);
    }

    public function store(AddStudentSkill $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $student = $user->student;

        Skill::create([
            'student_id' => $student->id,
            'skill' => $request->skill,
        ]);

        return response()->json([
            'message' => 'Skill added successfully.',
        ], 200);
    }

    public function destroy(Skill $skill)
    {
        $user = Auth::user();

        $student = $user->student;

        if ($skill->student_id != $student->id) {
            return response()->json([
                'message' => 'No Access To Delete',
            ], 400);
        }

        $skill->delete();

        return response()->json([
            'message' => 'Skill deleted successfully.',
        ], 200);
    }

    public function getStudentSkills(Student $student)
    {
        $skills = Skill::where('student_id', $student->id)->get();

        return response()->json([
            'message' => 'Skills retrieved successfully.',
            'data' => $skills,
        ], 200);
    }
}
