<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handout extends Model
{
    /** @use HasFactory<\Database\Factories\HandoutsFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'course_id',
        'lecture_id',
        'academic_year_id',
        'student_id'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
