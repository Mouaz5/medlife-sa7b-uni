<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Complaint\StoreComplaintRequest;
use App\Http\Requests\Complaint\UpdateComplaintRequest;
use App\Http\Resources\ComplaintResource;
use App\Http\Resources\ComplaintTypeResource;
use App\Models\Complaint;
use App\Models\ComplaintFile;
use App\Models\ComplaintType;
use App\Services\UploadService;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    protected $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index() {
        // student can display his complaints
        $student = auth()->user()->student;
        $complaints = $student->complaints()
            ->with(['type', 'files'])
            ->latest()
            ->get();
        
        return response()->json([
            ApiFormatter::success('Complaints retrieved successfully.', ComplaintResource::collection($complaints))
        ]);
    }

    public function show(Complaint $complaint) {
        if ($complaint->student_id !== auth()->user()->student->id) {
            return response()->json(ApiFormatter::error('Unauthorized', 'You are not authorized to view this complaint.'), 403);
        }
        
        // Load the relationships
        $complaint->load(['type', 'files']);
        
        return response()->json(
            ApiFormatter::success('Complaint retrieved successfully.', new ComplaintResource($complaint))
        );
    }

    public function store(StoreComplaintRequest $request) {
        $student = auth()->user()->student;

        $complaint = Complaint::create([
            'title' => $request->title,
            'description' => $request->description,
            'type_id' => $request->type_id,
            'student_id' => $student->id
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Create a new request with the current file
                $fileRequest = new Request();
                $fileRequest->files->set('image', $image);
                
                $filePath = $this->uploadService->uploadFile($fileRequest, 'image', 'complaint_files');
                if ($filePath) {
                    ComplaintFile::create([
                        'complaint_id' => $complaint->id,
                        'image' => $filePath
                    ]);
                }
            }
        }

        $complaint->load(['type', 'files']);

        return response()->json([
            ApiFormatter::success('Complaint created successfully.', new ComplaintResource($complaint))
        ]);
    }

    public function update(UpdateComplaintRequest $request, Complaint $complaint) {
        if ($complaint->student_id !== auth()->user()->student->id) {
            return response()->json(ApiFormatter::error('Unauthorized', 'You are not authorized to update this complaint.'), 403);
        }

        $complaint->update($request->validated());
        $complaint->load(['type', 'files']);

        return response()->json(
            ApiFormatter::success('Complaint updated successfully.', new ComplaintResource($complaint)), 200
        );
    }

    public function destroy(Complaint $complaint) {
        if ($complaint->student_id !== auth()->user()->student->id) {
            return response()->json(ApiFormatter::error('Unauthorized', 'You are not authorized to delete this complaint.'), 403);
        }

        $complaint->delete();

        return response()->json(
            ApiFormatter::success('Complaint deleted successfully.'), 200
        );
    }

    /**
     * Get all complaint types
     */
    public function getComplaintTypes() {
        $complaintTypes = ComplaintType::all();
        
        return response()->json([
            ApiFormatter::success('Complaint types retrieved successfully.', ComplaintTypeResource::collection($complaintTypes))
        ]);
    }
}
