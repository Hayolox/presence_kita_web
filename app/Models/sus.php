<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sus extends Model
{
    use HasFactory;
    protected $fillable = ['Q1','Q2','Q3','Q4','Q5','Q6','Q7','Q8','Q9', 'Q10'];
}
