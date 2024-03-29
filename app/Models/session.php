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

    'classrooms_id', 'year', 'room_id', 'geolocation'

    ];


    public function lecturer()
    {
        return $this->hasOne(lecturer::class, 'nip', 'lecturer_nip');
    }

    public function room()
    {
        return $this->hasOne(room::class, 'id', 'room_id');
    }
}
