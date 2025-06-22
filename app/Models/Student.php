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
        'bio',
        'image',
        'user_id',
        'college_id',
        'linkedIn_account',
        'facebook_account',
        'github_account',
        'x_account',
    ];
    protected $hidden = [
        'pivot'
    ];
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    public function followers()
    {
        return $this->belongsToMany(Student::class, 'foreign_key', 'local_key');
    }
    public function courses()
{
    return $this->belongsToMany(Course::class, 'student_courses');
}
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function academicTimeline()
    {
        return $this->hasMany(StudentAcademicTimeline::class);
    }
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function followerStudents()
    {
        return $this->belongsToMany(Student::class, 'follows', 'followed_id', 'follower_id');
    }

    public function followingStudents()
    {
        return $this->belongsToMany(Student::class, 'follows', 'follower_id', 'followed_id');
    }

    public function privacySettings()
    {
        return $this->hasOne(PrivacySetting::class);
    }
}
