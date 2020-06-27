<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WlgCorporationCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'wlg_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
