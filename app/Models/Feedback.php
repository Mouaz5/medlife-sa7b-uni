<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /** @use HasFactory<\Database\Factories\FeedbackFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'date',
        'course_id',
        'author_id',
        'type',
        'status'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function author()
    {
        return $this->belongsTo(Student::class);
    }
    public function questions()
    {
        return $this->hasMany(FeedbackQuestion::class);
    }
    public function answers()
    {
        return $this->hasMany(FeedbackAnswer::class);
    }
}
