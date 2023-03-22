<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asistantpratikum extends Model
{
    use HasFactory;

    protected $fillable = ['student_nsn', 'classroomspratikum_id'];

    public function classroompratikum()
    {
        return $this->hasOne(classroomspratikum::class, 'id', 'classroomspratikum_id');
    }
}
