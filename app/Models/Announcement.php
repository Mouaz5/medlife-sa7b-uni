<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    /** @use HasFactory<\Database\Factories\AnnouncementsFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'author_id',
        'course_id',
        'topic_id',
        'published_at',
        'expires_at'
    ];
    public function author()
    {
        return $this->belongsTo(Student::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
