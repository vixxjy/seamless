<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Course extends Model
{
    protected $fillable = [
        'text', 'lecturer', 'note', 'code', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}
