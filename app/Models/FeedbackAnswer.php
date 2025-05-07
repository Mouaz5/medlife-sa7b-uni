<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\FeedbackAnswerFactory> */
    use HasFactory;
    protected $fillable = [
        'student_id',
        'feedback_id',
        'answer'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}
