<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintFile;
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
            ApiFormatter::success('Complaints retrieved successfully.', $complaints)
        ]);
    }

    public function show(Complaint $complaint) {
        if ($complaint->student_id !== auth()->user()->student->id) {
            return response()->json(ApiFormatter::error('Unauthorized', 'You are not authorized to view this complaint.'), 403);
        }
        $complaint->load(['type', 'files']);
        return response()->json(
            ApiFormatter::success('Complaint retrieved successfully.', $complaint)
        );
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|min:5',
            'description' => 'required|string|min:10',
            'type_id' => 'required|exists:complaint_types,id',
            'images' => 'nullable|array',
        ]);

        $student = auth()->user()->student;

        $complaint = Complaint::create([
            'title' => $request->title,
            'description' => $request->description,
            'type_id' => $request->type_id,
            'student_id' => $student->id
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filePath = $this->uploadService->uploadFile($request, $image, 'complaint_files');
                if ($filePath) {
                    ComplaintFile::create([
                        'complaint_id' => $complaint->id,
                        'image' => $filePath
                    ]);
                }
            }
        }

        $complaint->load('files');

        return response()->json([
            ApiFormatter::success('Complaint created successfully.', $complaint)
        ]);
    }

    public function update(Request $request, Complaint $complaint) {
        if ($complaint->student_id !== auth()->user()->student->id) {
            return response()->json(ApiFormatter::error('Unauthorized', 'You are not authorized to update this complaint.'), 403);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|min:5',
            'description' => 'sometimes|required|string|min:10',
            'type_id' => 'sometimes|required|exists:complaint_types,id',
            ]);

        $complaint->update($validatedData);
        $complaint->load(['type', 'files']);

        return response()->json(
            ApiFormatter::success('Complaint updated successfully.', $complaint), 200
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
}
