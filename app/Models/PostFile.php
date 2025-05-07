<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostFile extends Model
{
    /** @use HasFactory<\Database\Factories\PostFileFactory> */
    use HasFactory;
    protected $fillable = [
        'file',
        'post_id'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
