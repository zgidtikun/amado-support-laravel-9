<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'it_employee';
    protected $fillable = [
        'it_emp_id', 'it_emp_name', 'it_emp_surname', 'it_emp_nickname', 'it_emp_tel', 
        'it_emp_email', 'it_emp_active', 'it_dept_id'
    ];
}
