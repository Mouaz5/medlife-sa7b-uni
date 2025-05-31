<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{

    use HasFactory;
    protected $fillable = [
        'title',
        'type',
        'description',
        'student_id'
    ];

    protected $with =['files'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function files()
    {
        return $this->hasMany(ComplaintFile::class);
    }
}
