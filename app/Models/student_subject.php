<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_subject extends Model
{
    use HasFactory;

    protected $fillable = ['student_nsn', 'year', 'classrooms_id'];



    public function student()
    {
        return $this->hasOne(student::class, 'nsn', 'student_nsn');
    }


    public function room()
    {
        return $this->hasOne(room::class, 'id', 'room_id');
    }

    public function classroom()
    {
        return $this->hasOne(classroom::class, 'id', 'classrooms_id');
    }
}
