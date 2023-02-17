<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lecturer extends Model
{
    use HasFactory;
    protected $primaryKey = 'nip';

    protected $fillable = ['nip','full_name','username', 'password', 'major_id'];


    public function major()
    {
        return $this->hasOne(major::class, 'id', 'major_id');
    }
}
