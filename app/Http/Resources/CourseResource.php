<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'course_name' => $this->name,
            'lectures' => $this->lectures->map(function ($lecture) {
                return [
                    'id' => $lecture->id,
                    'title' => $lecture->title,
                    'created_at' => $lecture->created_at->format('Y-m-d'),
                ];
            }),
            'handouts' => $this->handouts->map(function ($handout) {
                return [
                    'id' => $handout->id,
                    'title' => $handout->title,
                    'content' => $handout->content,
                    'created_at' => $handout->created_at->format('Y-m-d')
                ];
            }),
            'exams' => $this->exams->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'title' => $exam->title,
                    'exam_content' => $exam->exam_content,
                    'solution_content' => $exam->solution_content,
                    'created_at' => $exam->created_at->format('Y-m-d')
                ];
            }),
            'academicGuidance' => $this->academicGuidance,
            'events' => $this->events,
            'announcements' => $this->announcements
        ];
    }
}
