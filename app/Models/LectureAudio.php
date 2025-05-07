<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureAudio extends Model
{
    /** @use HasFactory<\Database\Factories\LectureAudioFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'lecture_id',
        'academic_year_id',
        'student_id'
    ];
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
