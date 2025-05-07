<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Course;
use App\Models\AcademicGuidanceVote;

class AcademicGuidance extends Model
{
    /** @use HasFactory<\Database\Factories\AcademicGuidanceFactory> */
    use HasFactory;
    protected $table = 'academic_guidance';
    protected $fillable = [
        'student_id', // author_id
        'course_id',
        'content',
        'type',
        'vote_count'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function votes()
    {
        return $this->hasMany(AcademicGuidanceVote::class);
    }
}
