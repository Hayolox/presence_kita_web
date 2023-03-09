<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sus_student extends Model
{
    use HasFactory;

    protected $fillable = ['student_nsn', 'Q1', 'Q2', 'Q3','Q4','Q5','Q6','Q7','Q8','Q9','Q10', 'amount' ];

    public function student()
    {
        return $this->hasOne(student::class, 'nsn', 'student_nsn');
    }
}
