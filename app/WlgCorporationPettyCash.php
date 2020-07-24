<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WlgCorporationPettyCash extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
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

