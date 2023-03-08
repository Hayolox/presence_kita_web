<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class check_login extends Model
{
    use HasFactory;

    protected $fillable = ['student_nsn'];

    public function student()
    {
        return $this->hasOne(student::class, 'nsn', 'student_nsn');
    }
}
