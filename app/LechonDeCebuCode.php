<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LechonDeCebuCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'lechon_de_cebu_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
