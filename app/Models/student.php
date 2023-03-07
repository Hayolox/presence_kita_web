<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Model;
use Laravel\Sanctum\HasApiTokens;

class student extends Model
{
    use  HasApiTokens, HasFactory;

    protected $primaryKey = 'nsn';
    public $incrementing = false;
    protected $keyType = 'string';



    protected $fillable = ['nsn', 'name', 'generation', 'password', 'major_id', 'IMEI'];


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
        return 'nsn';
    }
}
