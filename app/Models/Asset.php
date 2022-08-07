<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'it_asset';
    protected $fillable = [
        'it_asst_id', 'it_asst_number', 'it_asst_name', 'it_asstty_id', 'it_asst_serial', 
        'it_asst_status', 'it_asst_group', 'it_asst_remark', 'it_asst_price', 'it_asst_expired',
        'it_asst_warrantry'
    ];
}
