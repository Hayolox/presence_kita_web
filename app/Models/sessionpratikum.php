<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sessionpratikum extends Model
{
    use HasFactory;

    protected $fillable = [

        'QrCode', 'title', 'start', 'finish',

        'date', 'student_nsn', 'semester_id',

        'classroomspratikum_id', 'year', 'room_id', 'geolocation'

        ];


    public function student()
    {
        return $this->hasOne(student::class, 'nsn', 'student_nsn');
    }

    public function room()
    {
        return $this->hasOne(room::class, 'id', 'room_id');
    }
}
