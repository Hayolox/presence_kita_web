<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lecturer_subject extends Model
{
    use HasFactory;

    protected $fillable = ['lecturer_nip', 'classrooms_id'];


    public function lecturer()
    {
        return $this->hasOne(lecturer::class, 'nip', 'lecturer_nip');
    }

    public function classroom()
    {
        return $this->hasOne(classroom::class, 'id', 'classrooms_id');
    }
}
