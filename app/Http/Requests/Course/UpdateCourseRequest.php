<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{

    public function rules(): array
    {
    $currentCourseId = $this->route('course') ?? $this->route('id'); 
    
    $uniqueNameRule = Rule::unique('courses', 'name')
        ->where(function ($query) use ($currentCourseId) {
            if ($currentCourseId) {
                $query->where('id', '<>', $currentCourseId);
            }
        });

    return [
        "name" => [
            "sometimes",
            "string",
            "max:100",
            $uniqueNameRule 
        ],
        "collage_id" => "sometimes|integer|exists:collages,id",
        "semester_id" => "sometimes|integer|exists:semesters,id",
    ];
    }
}
