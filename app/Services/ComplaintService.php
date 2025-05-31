<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Complaint;
use App\Models\ComplaintFile;
use Illuminate\Support\Facades\DB;

class ComplaintService
{

    public function storeComplaint(array $data, $studentId)
    {
        return DB::transaction(function () use ($data, $studentId) {
            $complaint = Complaint::create([
                'title' => $data['title'],
                'type' => $data['type'],
                'description' => $data['description'],
                'student_id' => $studentId,
            ]);

            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    $path = FileHelper::upload($image, 'complaints');
                    ComplaintFile::create([
                        'complaint_id' => $complaint->id,
                        'image' => $path,
                    ]);
                }
            }

            return $complaint->load('files');
        });
    }

}
