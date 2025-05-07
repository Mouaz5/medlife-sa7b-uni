<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /** @use HasFactory<\Database\Factories\ExamFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'exam_content',
        'solution_content',
        'course_id',
        'academic_year_id'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
