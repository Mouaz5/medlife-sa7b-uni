<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEvent extends Model
{
    /** @use HasFactory<\Database\Factories\CourseEventFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'type',
        'session_type',
        'start_date',
        'end_date',
        'course_id'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
