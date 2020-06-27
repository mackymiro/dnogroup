<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoResourcesDevelopmentCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'dno_resources_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
