<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicGuidanceVote extends Model
{
    /** @use HasFactory<\Database\Factories\AcademicGuidanceVoteFactory> */
    use HasFactory;
    protected $fillable = [
        'student_id',
        'academic_guidance_id',
        'type'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function guidance()
    {
        return $this->belongsTo(AcademicGuidance::class);
    }
}
