<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAcademicTimeline extends Model
{
    /** @use HasFactory<\Database\Factories\StudentAcademicTimelineFactory> */
    use HasFactory;
    protected $fillable = [
        'study_year_id',
        'student_id',
        'specialization_id',
        'academic_year_id'
    ];
    public function study_year()
    {
        return $this->belongsTo(StudyYear::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function academic_year()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
