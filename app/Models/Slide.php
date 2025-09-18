<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slides';
    protected $fillable = [
        'title', 'content', 'lecture_id'
    ];
    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
