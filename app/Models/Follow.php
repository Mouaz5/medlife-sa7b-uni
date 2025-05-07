<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /** @use HasFactory<\Database\Factories\FollowFactory> */
    use HasFactory;
    protected $fillable = [
        'follower_id',
        'followed_id'
    ];
    public function follower()
    {
        return $this->belongsTo(Student::class);
    }
    public function followed()
    {
        return $this->belongsTo(Student::class);
    }
}
