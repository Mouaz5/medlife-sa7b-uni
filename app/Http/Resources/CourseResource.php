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
            'collage_id' => $this->collage_id,
            'collage_name' => $this->collage->name ?? null,
            'university_id' => $this->collage->university->id ?? null,
            'university_name' => $this->collage->university->name ?? null,
            'semester_term' => $this->semester->term ?? null,
            'academic_year_id' => $this->semester->academicYear->id ?? null ,
            'academic_year_year' => $this->semester->academicYear->year ?? null,
            'study_year_id' => $this->semester->studyYear->id ?? null,
            'study_year_year' => $this->semester->studyYear->year ?? null,
        ];
    }
}
