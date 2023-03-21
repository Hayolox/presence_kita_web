<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classroom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subject_course_code'];


    public function subject()
    {
        return $this->hasOne(subject::class, 'course_code', 'subject_course_code');
    }


    public function classroom()
    {
        return $this->hasOne(classroom::class, 'id', 'classrooms_id');
    }

}
