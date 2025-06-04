<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            "name" => "required|string|max:100|unique:courses,name" , 
            "collage_id" => "required|integer|exists:collages,id" , 
            "semester_id" => "required|integer|exists:semesters,id" , 
        ];
    }
}
