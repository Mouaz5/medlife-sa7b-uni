<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintType extends Model
{
    use HasFactory;
    protected $table = 'complaint_types';
    protected $fillable = [
        'type'
    ];

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
