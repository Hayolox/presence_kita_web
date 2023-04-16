<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class history_kecurangan extends Model
{
    use HasFactory;

    protected $fillable = ['student_nsn', 'tahun', 'semester_id'];

    public function student()
    {
        return $this->hasOne(student::class, 'nsn', 'student_nsn');
    }

    public function semester()
    {
        return $this->hasOne(semester::class, 'id', 'semester_id');
    }
}
