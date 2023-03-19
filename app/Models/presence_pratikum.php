<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presence_pratikum extends Model
{
    use HasFactory;

    protected $fillable = ['session_pratikum_id', 'classroomspratikum_id', 'student_nsn', 'status'];

    public function student()
    {
        return $this->hasOne(student::class, 'nsn', 'student_nsn');
    }
}
