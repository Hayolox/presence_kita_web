<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class session extends Model
{
    use HasFactory;

    protected $fillable = [

    'QrCode', 'title', 'start', 'finish',

    'date', 'lecturer_nip', 'semester_id',

    'subject_course_code', 'year', 'room_id', 'geolocation'

    ];


    public function lecturer()
    {
        return $this->hasOne(lecturer::class, 'nip', 'lecturer_nip');
    }
}
