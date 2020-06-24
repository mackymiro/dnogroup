<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DongFangCorporationPettyCash extends Model
{
    //
    protected $fillable = [
        'user_id',
        'pc_id',
        'date',
        'petty_cash_name',
        'petty_cash_summary',
        'amount',
        'created_by',
    ];
}
