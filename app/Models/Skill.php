<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /** @use HasFactory<\Database\Factories\SkillFactory> */
    use HasFactory;
    protected $fillable = [
        'student_id',
        'skill'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
