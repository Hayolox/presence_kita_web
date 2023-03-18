<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classroomspratikum extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subject_course_code'];


    public function subject()
    {
        return $this->hasOne(subject::class, 'course_code', 'subject_course_code');
    }


    public function asisten(){
        return $this->belongsTo(asistantpratikum::class, 'id', 'classroomspratikum_id');
    }
}
