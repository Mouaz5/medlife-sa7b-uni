<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Slide;
use App\Models\Summary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LectureController extends Controller
{
    public function index(Course $course)
    {
        $lectures = $course->lectures()
            ->with(['course', 'academicYear'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(
            ApiFormatter::success(
                'lectures index successfully',
                LectureResource::collection($lectures)
            )
        );
    }

    public function slides(Course $course) {
        // Get all lectures for the course, ordered by creation date, and eager load the slides.
        $lecturesWithSlides = $course->lectures()
            ->with('slides')
            ->orderBy('created_at', 'desc')
            ->get();
        $slides = $lecturesWithSlides->pluck('slides')->flatten();
        $slides = $slides->map(function ($slide) {
            return [
                'id' => $slide->id,
                'title' => $slide->title,
                'content' => $slide->content,
                'download_url' => $slide->content ? asset('storage/' . $slide->content) : null,
                'file_type' => $slide->content ? pathinfo($slide->content, PATHINFO_EXTENSION) : null,
                'lecture_id' => $slide->lecture_id,
                'created_at' => $slide->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $slide->updated_at->format('Y-m-d H:i:s')
            ];
        });
        return response()->json(
            ApiFormatter::success(
                'slides retrieved successfully',
                $slides
            )
        );
    }
    public function audios(Course $course) {
        $lecturesWithAudios = $course->lectures()
            ->with('audios')
            ->orderBy('created_at', 'desc')
            ->get();
        $audios = $lecturesWithAudios->pluck('audios')->flatten();
        $audios = $audios->map(function ($audio) {
            return [
                'id' => $audio->id,
                'title' => $audio->title,
                'content' => $audio->content,
                'download_url' => $audio->content ? asset('storage/' . $audio->content) : null,
                'file_type' => $audio->content ? pathinfo($audio->content, PATHINFO_EXTENSION) : null,
                'lecture_id' => $audio->lecture_id,
                'academic_year_id' => $audio->academic_year_id,
                'created_at' => $audio->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $audio->updated_at->format('Y-m-d H:i:s')
            ];
        });
        return response()->json(
            ApiFormatter::success(
                'audios retrieved successfully',
                $audios
            )
        );
    }
    public function summaries(Course $course) {
        $lecturesWithSummaries = $course->lectures()
            ->with('summaries')
            ->orderBy('created_at', 'desc')
            ->get();
        $summaries = $lecturesWithSummaries->pluck('summaries')->flatten();
        $summaries = $summaries->map(function ($summary) {
            return [
                'id' => $summary->id,
                'title' => $summary->title,
                'content' => $summary->content,
                'download_url' => $summary->content ? asset('storage/' . $summary->content) : null,
                'file_type' => $summary->content ? pathinfo($summary->content, PATHINFO_EXTENSION) : null,
                'lecture_id' => $summary->lecture_id,
                'created_at' => $summary->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $summary->updated_at->format('Y-m-d H:i:s')
            ];
        });
        return response()->json(
            ApiFormatter::success(
                'summaries retrieved successfully',
                $summaries
            )
        );
    }
    public function academicGuidance(Course $course) {
        $academicGuidance = $course->academicGuidance()
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json(
            ApiFormatter::success(
                'academic guidance retrived successfully',
                $academicGuidance
            )
        );
    }
    public function announcements(Course $course) {
        $announcements = $course->announcements()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(
            ApiFormatter::success(
                'announcements retrived successfully',
                $announcements
            )
        );
    }
    public function show(Course $course, Lecture $lecture)
    {
        if ($lecture->course_id !== $course->id) {

            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $lecture->load(['course', 'academicYear', 'audios']);

        return response()->json(
            ApiFormatter::success(
                'lecture retrieved successfully',
                new LectureResource($lecture)
            )
        );
    }

    /**
     * Get individual slide details
     */
    public function getSlide(Slide $slide)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this slide's lecture course
        if (!$student->courses()->where('course_id', $slide->lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        return response()->json([
            ApiFormatter::success('Slide retrieved successfully.', [
                'id' => $slide->id,
                'title' => $slide->title,
                'content' => $slide->content,
                'download_url' => $slide->content ? asset('storage/' . $slide->content) : null,
                'file_type' => $slide->content ? pathinfo($slide->content, PATHINFO_EXTENSION) : null,
                'lecture_id' => $slide->lecture_id,
                'lecture_title' => $slide->lecture->title,
                'created_at' => $slide->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $slide->updated_at->format('Y-m-d H:i:s')
            ])
        ]);
    }

    /**
     * Get individual audio details
     */
    public function getAudio(LectureAudio $audio)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this audio's lecture course
        if (!$student->courses()->where('course_id', $audio->lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        return response()->json([
            ApiFormatter::success('Audio retrieved successfully.', [
                'id' => $audio->id,
                'title' => $audio->title,
                'content' => $audio->content,
                'download_url' => $audio->content ? asset('storage/' . $audio->content) : null,
                'file_type' => $audio->content ? pathinfo($audio->content, PATHINFO_EXTENSION) : null,
                'lecture_id' => $audio->lecture_id,
                'lecture_title' => $audio->lecture->title,
                'academic_year_id' => $audio->academic_year_id,
                'created_at' => $audio->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $audio->updated_at->format('Y-m-d H:i:s')
            ])
        ]);
    }

    /**
     * Get individual summary details
     */
    public function getSummary(Summary $summary)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this summary's lecture course
        if (!$student->courses()->where('course_id', $summary->lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        return response()->json([
            ApiFormatter::success('Summary retrieved successfully.', [
                'id' => $summary->id,
                'title' => $summary->title,
                'content' => $summary->content,
                'download_url' => $summary->content ? asset('storage/' . $summary->content) : null,
                'file_type' => $summary->content ? pathinfo($summary->content, PATHINFO_EXTENSION) : null,
                'lecture_id' => $summary->lecture_id,
                'lecture_title' => $summary->lecture->title,
                'created_at' => $summary->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $summary->updated_at->format('Y-m-d H:i:s')
            ])
        ]);
    }

    /**
     * Download slide file
     */
    public function downloadSlide(Slide $slide)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this slide's lecture course
        if (!$student->courses()->where('course_id', $slide->lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        if (!$slide->content || !file_exists(storage_path('app/public/' . $slide->content))) {
            return response()->json(
                ApiFormatter::error('File not found', 'The requested file does not exist.'), 
                404
            );
        }

        return response()->download(storage_path('app/public/' . $slide->content), $slide->title);
    }

    /**
     * Download audio file
     */
    public function downloadAudio(LectureAudio $audio)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this audio's lecture course
        if (!$student->courses()->where('course_id', $audio->lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        if (!$audio->content || !file_exists(storage_path('app/public/' . $audio->content))) {
            return response()->json(
                ApiFormatter::error('File not found', 'The requested file does not exist.'), 
                404
            );
        }

        return response()->download(storage_path('app/public/' . $audio->content), $audio->title);
    }

    /**
     * Download summary file
     */
    public function downloadSummary(Summary $summary)
    {
        $student = auth()->user()->student;
        
        // Verify the student has access to this summary's lecture course
        if (!$student->courses()->where('course_id', $summary->lecture->course_id)->exists()) {
            return response()->json(
                ApiFormatter::error('Unauthorized', 'You are not enrolled in this course.'), 
                403
            );
        }

        if (!$summary->content || !file_exists(storage_path('app/public/' . $summary->content))) {
            return response()->json(
                ApiFormatter::error('File not found', 'The requested file does not exist.'), 
                404
            );
        }

        return response()->download(storage_path('app/public/' . $summary->content), $summary->title);
    }
}
