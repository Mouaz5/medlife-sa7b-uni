<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyYear extends Model
{
    /** @use HasFactory<\Database\Factories\StudyYearFactory> */
    use HasFactory;
    protected $fillable = [
        'year'
    ];
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function semsters()
    {
        return $this->hasMany(Semester::class);
    }
}
