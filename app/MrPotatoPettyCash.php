<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MrPotatoPettyCash extends Model
{
    //
    protected $fillable = [
        'user_id',
        'pc_id',
        'petty_cash_no',
        'date',
        'petty_cash_name',
        'petty_cash_summary',
        'amount',
        'created_by',
    ];
}