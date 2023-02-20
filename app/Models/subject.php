<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;
    protected $primaryKey = 'course_code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['course_code', 'full_name', 'nickname', 'major_id','semester_id',];



    public function major()
    {
        return $this->hasOne(major::class, 'id', 'major_id');
    }

    public function semester()
    {
        return $this->hasOne(semester::class, 'id', 'semester_id');
    }



}
