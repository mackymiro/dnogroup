<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoPersonalProperty extends Model
{
    //
    protected $fillable = [
        'user_id',
        'pp_id',
        'property_name',
        'property_account_code',
        'property_account_name',
        'address',
        'unit',
        'status',
        'flag',
        'created_by',
    ];

}
