<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentAccount\UpdateStudentAccountRequest;
use App\Models\Student;
use App\Services\FileUploadService;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAccountController extends Controller
{

    protected $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function getMyAccount()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        return response()->json([
            'message' => 'Account Retrieved Successfully',
            'data' => $user->student
        ]);
    }

    public function getStudentAccount(Student $student)
    {
        if (!$student) {
            return response()->json([
                'message' => 'Student Not Found',
            ], 404);
        }

        return response()->json([
            'message' => 'Account Retrieved Successfully',
            'data' => $student
        ]);
    }

    public function searchStudentAccount(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'message' => 'Search string is required.',
            ], 400);
        }

        $query = trim($query);

        $name_parts = array_filter(explode(' ', $query));

        $matching = [];

        foreach ($name_parts as $name) {
            $student_ids = Student::whereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", ["%{$name}%"])
                ->pluck('id')
                ->toArray();

            $matching[] = $student_ids;
        }

        $common_ids = array_shift($matching);
        foreach ($matching as $ids) {
            $common_ids = array_intersect($common_ids, $ids);
        }

        $students = Student::whereIn('id', $common_ids)->get();

        return response()->json([
            'message' => $students->isEmpty() ? 'No students found' : 'Students found successfully.',
            'data' => $students,
        ]);
    }

    public function deleteAccount()
    {
        $student = Auth::user();

        if (!$student) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $student->delete();
        return response()->json([
            'message' => 'Account Deleted Successfully',
        ]);
    }


    public function updateAccount(UpdateStudentAccountRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $student = $user->student;

        foreach ($validated as $key => $value) {
            if (!is_null($value)) {
                $student->$key = $value;
            }
        }
        if ($request->hasFile('image')) {
            $student['image'] = $this->uploadService->uploadFile($request, 'image', 'students');
        }
        $student->save();

        return response()->json([
            'message' => 'Student Account updated successfully!',
        ]);
    }
}
