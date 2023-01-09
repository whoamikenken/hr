<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkFromHome extends Model
{
    use HasFactory;

    protected $fillable = [
        'applied_by',
        'employee_id',
        'purpose',
        'work_done',
        'accomplishment_file',
        'office_head',
        'read_office_head',
        'email_office_head',
        'date_approved',
        'date',
        'updated_at',
        'updated_by',
        'created_at',
        'created_by'
    ];
}
