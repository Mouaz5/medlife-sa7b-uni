<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    /** @use HasFactory<\Database\Factories\CertificateFactory> */
    use HasFactory;
    protected $fillable = [
        'file',
        'student_id'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
