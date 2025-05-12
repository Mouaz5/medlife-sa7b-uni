<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    /** @use HasFactory<\Database\Factories\SemestersFactory> */
    use HasFactory;
    protected $fillable = [
        'term',
        'academic_year_id',
        'study_year_id'
    ];
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function studyYear()
    {
        return $this->belongsTo(StudyYear::class);
    }
}
