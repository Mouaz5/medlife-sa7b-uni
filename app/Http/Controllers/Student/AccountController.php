<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentAccount\UpdateStudentAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Skill;
use App\Models\Student;
use App\Models\StudentAcademicTimeline;
use App\Services\UploadService;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    protected $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function account()
    {
        $student = auth()->user()->student;
        return response()->json(
            ApiFormatter::success(
                'Account Retrieved Successfully',
                new AccountResource($student)
            ));
    }

    public function getStudentAccount(Student $student)
    {
        return response()->json([
            'message' => 'Account Retrieved Successfully',
            'data' => new AccountResource($student)
        ]);
    }

    public function deleteAccount()
    {
        $student = Auth::user();

        if (!$student) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $student->delete();
        return response()->json(
            ApiFormatter::success('Account Deleted Successfully')
        );
    }


    public function updateAccount(UpdateStudentAccountRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();

        $student = $user->student;

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadService->uploadFile($request, 'image', 'students');
        }
        $skills = $request->input('skills', null);
        unset($validated['skills']);

        $academicYearId = $request->input('academic_year_id', null);
        unset($validated['academic_year_id']);

        $validated = array_filter($validated, function($value) {
            return !is_null($value);
        });

        $user->update($validated);
        $student->update($validated);

        if ($skills !== null) {
            $student->skills()->whereIn('skill', $skills)->delete();
            
            $existingSkills = $student->skills()->pluck('skill')->toArray();
            
            $newSkills = array_filter($skills, function($skill) use ($existingSkills) {
                return !in_array($skill, $existingSkills);
            });
            
            if (!empty($newSkills)) {
                $skillsData = array_map(function($skill) use ($student) {
                    return [
                        'student_id' => $student->id,
                        'skill' => $skill,
                    ];
                }, $newSkills);
                
                Skill::insert($skillsData);
            }
        }

        StudentAcademicTimeline::where('academic_year_id', $academicYearId)->update(['student_id' => $student->id]);

        return response()->json(
            ApiFormatter::success('Account Updated Successfully')
        );
    }
}
