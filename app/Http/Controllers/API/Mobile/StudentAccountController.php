<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentAccount\UpdateStudentAccountRequest;
use App\Http\Resources\AccountResource;
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

    public function account()
    {
        $student = auth()->user()->student;
        return response()->json([
            'message' => 'Account Retrieved Successfully',
            'data' => new AccountResource($student)
        ]);
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
