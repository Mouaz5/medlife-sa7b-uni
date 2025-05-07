<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'visibility',
        'student_id'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function files()
    {
        return $this->hasMany(PostFile::class);
    }
}
