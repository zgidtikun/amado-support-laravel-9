<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'it_location';
    protected $fillable = [
        'it_locat_id',
        'it_locat_name'
    ];
}
