<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_pratikum extends Model
{
    use HasFactory;

    protected $fillable = ['student_nsn', 'classroomspratikum_id', 'year'];


    public function student()
    {
        return $this->hasOne(student::class, 'nsn', 'student_nsn');
    }


    public function room()
    {
        return $this->hasOne(room::class, 'id', 'room_id');
    }

    public function classroompratikum()
    {
        return $this->hasOne(classroomspratikum::class, 'id', 'classroomspratikum_id');
    }
}
