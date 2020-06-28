<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DinoIndustrialCorporationCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'dic_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
