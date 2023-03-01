<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sus_student extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->hasOne(student::class, 'nsn', 'student_nsn');
    }
}
