<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asistantpratikum extends Model
{
    use HasFactory;

    protected $fillable = ['student_nsn', 'classroomspratikum_id'];
}
