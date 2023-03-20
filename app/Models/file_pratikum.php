<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class file_pratikum extends Model
{
    use HasFactory;
    protected $fillable = ['session_pratikum_id', 'student_nsn', 'path', 'status', 'created_at', 'updated_at'];
}
