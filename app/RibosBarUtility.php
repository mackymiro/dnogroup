<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RibosBarUtility extends Model
{
    //
    protected $fillable = [
        'user_id',
        'u_id',
        'account_id',
        'account_name',
        'meter_no',
        'date',
        'status',
        'flag',
        'created_by',
    ];
}

