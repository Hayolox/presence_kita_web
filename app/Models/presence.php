<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presence extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'subject_course_code', 'student_nsn', 'status'];

    public function student()
    {
        return $this->hasOne(student::class, 'nsn', 'student_nsn');
    }
}
