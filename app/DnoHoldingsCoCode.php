<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoHoldingsCoCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'dno_holdings_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
