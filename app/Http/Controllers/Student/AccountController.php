<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentAccount\UpdateStudentAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Student;
use App\Services\FileUploadService;
use App\Services\UploadService;
use Illuminate\Http\Request;
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
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $student = $user->student;

        $validated = array_filter($validated, function($value) {
            return !is_null($value);
        });
        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadService->uploadFile($request, 'image', 'students');
        }
        $user->update($validated);
        $student->update($validated);

        return response()->json(
            ApiFormatter::success('Account Updated Successfully')
        );
    }
}
