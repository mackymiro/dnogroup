<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoPersonalProperty extends Model
{
    //
    protected $fillable = [
        'user_id',
        'pp_id',
        'date',
        'property_name',
        'property_account_code',
        'property_account_name',
        'address',
        'unit',
        'status',
        'flag',
        'account_name',
        'account_id',
        'meter_no',
        'account_no',
        'telephone_no',
        'created_by',
    ];

}
