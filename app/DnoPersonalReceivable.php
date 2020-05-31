<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoPersonalReceivable extends Model
{
    //
    protected $fillable = [
        'user_id',
        'r_id',
        'name_of_tenant',
        'contract_date',
        'unit_no',
        'monthly_rent',
        'advance_deposit',
        'advance_deposit_amount',
        'period',
        'amount',
        'remarks',
        'status',
        'created_by',
    ];
}
