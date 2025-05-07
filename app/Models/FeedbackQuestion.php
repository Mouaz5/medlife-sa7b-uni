<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\FeedbackQuestionFactory> */
    use HasFactory;
    protected $fillable = [
        'student_id',
        'feedback_id',
        'question_text'
    ];
    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
