<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    /** @use HasFactory<\Database\Factories\ComplaintFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'type_id',
        'description',
        'student_id'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function type()
    {
        return $this->belongsTo(ComplaintType::class);
    }
    public function files()
    {
        return $this->hasMany(ComplaintFile::class);
    }
}
