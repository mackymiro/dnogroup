<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalGroundCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'local_ground_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
