<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'college_id',
        'semester_id'
    ];
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function events()
    {
        return $this->hasMany(CourseEvent::class);
    }
    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
    public function handouts()
    {
        return $this->hasMany(Handout::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_courses');
    }
    public function academicGuidance()
    {
        return $this->hasMany(AcademicGuidance::class);
    }
    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
