<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentWithCoursesResource extends JsonResource
{
    public function toArray($request)
    {
         return [
            'student_id' => $this->id,
            'full_name' => $this->full_name,
            'courses' => CourseResource::collection($this->whenLoaded('courses')),
        ];
    }
}