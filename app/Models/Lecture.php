<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    /** @use HasFactory<\Database\Factories\LectureFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'course_id',
        'academic_year_id',
        'student_id'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function audios()
    {
        return $this->hasMany(LectureAudio::class);
    }
    public function slides()
    {
        return $this->hasMany(Slide::class);
    }
    public function summaries()
    {
        return $this->hasMany(Summary::class);
    }
}
