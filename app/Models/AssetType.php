<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    use HasFactory;

    protected $table = 'it_asset_type';
    protected $fillable = [
        'it_asstty_id',
        'it_asstty_name'
    ];
}
