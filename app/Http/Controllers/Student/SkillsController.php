<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentSkills\AddStudentSkill;
use App\Models\Skill;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $student = $user->student;

        $skills = Skill::where('student_id', $student->id)->get();

        return response()->json(
            ApiFormatter::success('Skills retrieved successfully.', $skills)
        );
    }

    public function store(AddStudentSkill $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $student = $user->student;

        Skill::create([
            'student_id' => $student->id,
            'skill' => $request->skill,
        ]);

        return response()->json(
            ApiFormatter::success('Skill added successfully.')
        );
    }

    public function destroy(Skill $skill)
    {
        $user = Auth::user();

        $student = $user->student;

        if ($skill->student_id != $student->id) {
            return response()->json(
                ApiFormatter::error('You are not authorized to delete this skill.')
            );
        }

        $skill->delete();

        return response()->json(
            ApiFormatter::success('Skill deleted successfully.')
        );
    }

    public function getStudentSkills(Student $student)
    {
        $skills = Skill::where('student_id', $student->id)->get();

        return response()->json(
            ApiFormatter::success('Skills retrieved successfully.', $skills)
        );
    }
}
