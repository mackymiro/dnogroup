<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoPersonalCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'dno_personal_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
