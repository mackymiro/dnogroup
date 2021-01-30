<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LechonDeCebuContractor extends Model
{
    //
    protected $fillable = [
        'user_id',
        's_id',
        'c_id',
        'date',
        'contractor_name',
        'amount',
        'contract_date',
        'created_by',
    ];
}
