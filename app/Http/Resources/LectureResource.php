<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureResource extends JsonResource
{
       public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'course' => $this->course->name ?? null,
            'course' => $this->course->id ?? null,
            'academic_year' => $this->academicYear->year ?? null,
            'academic_year_id' => $this->academicYear->id ?? null,
            'files' => $this->files, 
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null
        ];
    }
}