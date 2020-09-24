<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoFoundationIncCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'dno_foundation_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
