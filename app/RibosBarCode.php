<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RibosBarCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'ribos_bar_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
