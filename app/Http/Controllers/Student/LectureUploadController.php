<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\LectureUpload\UploadSlideRequest;
use App\Http\Requests\LectureUpload\UploadAudioRequest;
use App\Http\Requests\LectureUpload\UploadSummaryRequest;
use App\Http\Requests\LectureUpload\UploadHandoutRequest;
use App\Models\Lecture;
use App\Models\Slide;
use App\Models\LectureAudio;
use App\Models\Summary;
use App\Models\Handout;
use App\Services\UploadService;
use Illuminate\Http\Request;

class LectureUploadController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Upload slide files for a lecture
     */
    public function uploadSlides(UploadSlideRequest $request, Lecture $lecture)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this lecture's course
        if (!$student->courses()->where('course_id', $lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        $uploadedFiles = [];

        if ($request->hasFile('slides')) {
            foreach ($request->file('slides') as $slide) {
                // Create a new request with the current file
                $fileRequest = new Request();
                $fileRequest->files->set('slide', $slide);
                
                $filePath = $this->uploadService->uploadFile($fileRequest, 'slide', 'lecture_slides');
                
                if ($filePath) {
                    $slideRecord = Slide::create([
                        'title' => $request->input('title', 'Slide ' . (count($uploadedFiles) + 1)),
                        'content' => $filePath,
                        'lecture_id' => $lecture->id
                    ]);
                    
                    $uploadedFiles[] = $slideRecord;
                }
            }
        }

        return response()->json([
            ApiFormatter::success('Slides uploaded successfully.', $uploadedFiles)
        ]);
    }

    /**
     * Upload audio files for a lecture
     */
    public function uploadAudios(UploadAudioRequest $request, Lecture $lecture)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this lecture's course
        if (!$student->courses()->where('course_id', $lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        $uploadedFiles = [];

        if ($request->hasFile('audios')) {
            foreach ($request->file('audios') as $audio) {
                // Create a new request with the current file
                $fileRequest = new Request();
                $fileRequest->files->set('audio', $audio);
                
                $filePath = $this->uploadService->uploadFile($fileRequest, 'audio', 'lecture_audios');
                
                if ($filePath) {
                    $audioRecord = LectureAudio::create([
                        'title' => $request->input('title', 'Audio ' . (count($uploadedFiles) + 1)),
                        'content' => $filePath,
                        'lecture_id' => $lecture->id,
                        'academic_year_id' => $lecture->academic_year_id,
                        'student_id' => $student->id
                    ]);
                    
                    $uploadedFiles[] = $audioRecord;
                }
            }
        }

        return response()->json([
            ApiFormatter::success('Audios uploaded successfully.', $uploadedFiles)
        ]);
    }

    /**
     * Upload summary files for a lecture
     */
    public function uploadSummaries(UploadSummaryRequest $request, Lecture $lecture)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this lecture's course
        if (!$student->courses()->where('course_id', $lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        $uploadedFiles = [];

        if ($request->hasFile('summaries')) {
            foreach ($request->file('summaries') as $summary) {
                // Create a new request with the current file
                $fileRequest = new Request();
                $fileRequest->files->set('summary', $summary);
                
                $filePath = $this->uploadService->uploadFile($fileRequest, 'summary', 'lecture_summaries');
                
                if ($filePath) {
                    $summaryRecord = Summary::create([
                        'title' => $request->input('title', 'Summary ' . (count($uploadedFiles) + 1)),
                        'content' => $filePath,
                        'lecture_id' => $lecture->id
                    ]);
                    
                    $uploadedFiles[] = $summaryRecord;
                }
            }
        }

        return response()->json([
            ApiFormatter::success('Summaries uploaded successfully.', $uploadedFiles)
        ]);
    }

    /**
     * Upload handout files for a lecture
     */
    public function uploadHandouts(UploadHandoutRequest $request, Lecture $lecture)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this lecture's course
        if (!$student->courses()->where('course_id', $lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        $uploadedFiles = [];

        if ($request->hasFile('handouts')) {
            foreach ($request->file('handouts') as $handout) {
                // Create a new request with the current file
                $fileRequest = new Request();
                $fileRequest->files->set('handout', $handout);
                
                $filePath = $this->uploadService->uploadFile($fileRequest, 'handout', 'lecture_handouts');
                
                if ($filePath) {
                    $handoutRecord = Handout::create([
                        'title' => $request->input('title', 'Handout ' . (count($uploadedFiles) + 1)),
                        'content' => $filePath,
                        'course_id' => $lecture->course_id,
                        'lecture_id' => $lecture->id,
                        'academic_year_id' => $lecture->academic_year_id,
                        'student_id' => $student->id
                    ]);
                    
                    $uploadedFiles[] = $handoutRecord;
                }
            }
        }

        return response()->json([
            ApiFormatter::success('Handouts uploaded successfully.', $uploadedFiles)
        ]);
    }

    /**
     * Delete a slide file
     */
    public function deleteSlide(Slide $slide)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this slide's lecture course
        if (!$student->courses()->where('course_id', $slide->lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        $slide->delete();

        return response()->json([
            ApiFormatter::success('Slide deleted successfully.')
        ]);
    }

    /**
     * Delete an audio file
     */
    public function deleteAudio(LectureAudio $audio)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this audio's lecture course
        if (!$student->courses()->where('course_id', $audio->lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        $audio->delete();

        return response()->json([
            ApiFormatter::success('Audio deleted successfully.')
        ]);
    }

    /**
     * Delete a summary file
     */
    public function deleteSummary(Summary $summary)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this summary's lecture course
        if (!$student->courses()->where('course_id', $summary->lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        $summary->delete();

        return response()->json([
            ApiFormatter::success('Summary deleted successfully.')
        ]);
    }

    /**
     * Delete a handout file
     */
    public function deleteHandout(Handout $handout)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this handout's lecture course
        if (!$student->courses()->where('course_id', $handout->lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        $handout->delete();

        return response()->json([
            ApiFormatter::success('Handout deleted successfully.')
        ]);
    }
}
