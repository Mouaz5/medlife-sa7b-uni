<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCertificates\AddStudentCertificate;
use App\Models\Certificate;
use App\Models\Student;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificatesController extends Controller
{
    protected $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function getMyCertificates()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $student = $user->student;

        $certificates = Certificate::where('student_id', $student->id)->get();

        return response()->json([
            'message' => 'Certificates retrieved successfully.',
            'data' => $certificates,
        ], 200);
    }

    public function addCertificate(AddStudentCertificate $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $student = $user->student;

        $certificate = Certificate::create([
            'student_id' => $student->id,
            'title' => $request->title
        ]);
        if ($request->hasFile('file')) {
            $certificate['file'] = $this->uploadService->uploadFile($request, 'file', 'certificates');
        }
        $certificate->save();


        return response()->json([
            'message' => 'Certificate added successfully.',
            'data' => $certificate,
        ], 200);
    }

    public function deleteCertificate(Certificate $certificate)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        if (!$certificate) {
            return response()->json([
                'message' => 'Certificate not found.',
            ], 404);
        }

        $student = $user->student;

        if ($certificate->student_id != $student->id) {
            return response()->json([
                'message' => 'No Access To Delete',
            ], 400);
        }

        $certificate->delete();

        return response()->json([
            'message' => 'Certificate deleted successfully.',
        ], 200);
    }

    public function getStudentCertificates(Student $student)
    {
        if (!$student) {
            return response()->json([
                'message' => 'Student not found.',
            ], 404);
        }

        $certificates = Certificate::where('student_id', $student->id)->get();

        return response()->json([
            'message' => 'Certificates retrieved successfully.',
            'data' => $certificates,
        ], 200);
    }
}
