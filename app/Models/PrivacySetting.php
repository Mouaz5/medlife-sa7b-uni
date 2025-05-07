<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacySetting extends Model
{
    /** @use HasFactory<\Database\Factories\PrivacySettingFactory> */
    use HasFactory;
    protected $fillable = [
        'student_id',
        'show_posts',
        'profile_visibility'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
