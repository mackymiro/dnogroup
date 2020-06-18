<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MrPotatoCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'mr_potato_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
