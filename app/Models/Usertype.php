<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usertype extends Model
{
    public $table = "usertype";

    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'read',
        'add',
        'delete',
        'edit',
        'created_by'
    ];
}
