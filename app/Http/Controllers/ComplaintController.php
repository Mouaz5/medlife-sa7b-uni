<?php

namespace App\Http\Controllers;

use App\Helpers\SendResponse;
use App\Http\Requests\StoreComplaintRequest;
use App\Models\Complaint;
use App\Models\Student;
use App\Services\ComplaintService;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    private $complaintService;

    public function __construct(ComplaintService $complaintService)
    {
        $this->complaintService = $complaintService ;

    }
    public function index()
    {
        $studentId = auth()->id();
        $student = Student::findOrFail($studentId);

        $complaints =  $student->complaints()->get();

        return SendResponse::success($complaints, 'Your complaints.');

    }

    public function show(Complaint $complaint)
    {
        $studentId =  auth()->id();
        if ($complaint->student_id !== $studentId){
            return SendResponse::error('You are not authorized'  ,403);
        }

        return SendResponse::success($complaint, 'Complaint details.');
    }




    public function store(StoreComplaintRequest $request)
    {
        $studentId =  auth()->id();
        $complaint = $this->complaintService->storeComplaint($request->validated(), $studentId);
        return SendResponse::success($complaint, 'Complaint created successfully.', 201);
    }


}
