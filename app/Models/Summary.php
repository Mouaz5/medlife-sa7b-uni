<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    protected $table = 'summaries';
    protected $fillable = [
        'title', 'content', 'lecture_id'
    ];
    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
