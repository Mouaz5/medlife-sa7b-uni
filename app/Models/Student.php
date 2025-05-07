<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'image',
        'user_id'
    ];
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function academicTimeline()
    {
        return $this->hasMany(AcademicTimeline::class);
    }
}
