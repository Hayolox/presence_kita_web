<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Model;

class lecturer extends Model
{
    use HasFactory;
    protected $primaryKey = 'nip';

    protected $fillable = ['nip','full_name','username', 'password', 'major_id'];


    public function major()
    {
        return $this->hasOne(major::class, 'id', 'major_id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifierName()
    {
        return 'username';
    }
}
