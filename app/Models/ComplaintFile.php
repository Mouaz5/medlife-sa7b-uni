<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintFile extends Model
{
    /** @use HasFactory<\Database\Factories\ComplaintFileFactory> */
    use HasFactory;
    protected $fillable = [
        'image',
        'complaint_id'
    ];
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
