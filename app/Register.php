<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $fillable = [
        'course_id', 'user_id', 'enrolled_date'
    ];
}
