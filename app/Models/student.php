<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;
    protected $primaryKey = 'nsn';
    public $timestamps = false;


    protected $fillable = ['nsn', 'name', 'generation', 'password', 'major_id'];


    public function major()
    {
        return $this->hasOne(major::class, 'id', 'major_id');
    }
}
