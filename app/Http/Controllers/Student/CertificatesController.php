<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
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
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $student = $user->student;

        $certificates = Certificate::where('student_id', $student->id)->get();

        return response()->json(
            ApiFormatter::success('Certificates retrieved successfully.', $certificates)
        );
    }

    public function addCertificate(AddStudentCertificate $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(
                ApiFormatter::notFound()
            );
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


        return response()->json(
            ApiFormatter::success('Certificate added successfully.', $certificate)
        );
    }

    public function deleteCertificate(Certificate $certificate)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        if (!$certificate) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $student = $user->student;

        if ($certificate->student_id != $student->id) {
            return response()->json(
                ApiFormatter::error('You are not authorized to delete this certificate.')
            );
        }

        $certificate->delete();

        return response()->json(
            ApiFormatter::success('Certificate deleted successfully.')
        );
    }

    public function getStudentCertificates(Student $student)
    {
        if (!$student) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $certificates = Certificate::where('student_id', $student->id)->get();

        return response()->json(
            ApiFormatter::success(
                'Certificates retrieved successfully.',
                $certificates
            )
        );
    }
}
