<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'it_department';
    protected $fillable = [
        'it_dept_id','it_dept_name'
    ];
}
