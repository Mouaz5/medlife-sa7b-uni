<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /** @use HasFactory<\Database\Factories\TopicFactory> */
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}
