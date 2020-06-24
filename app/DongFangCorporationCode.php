<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DongFangCorporationCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'dong_fang_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
