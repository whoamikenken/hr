<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPara extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'latitude',
        'longitude',
    ];
    
}
