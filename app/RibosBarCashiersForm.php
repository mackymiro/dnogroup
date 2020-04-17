<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RibosBarCashiersForm extends Model
{
    //
    protected $fillable = [
        'user_id',
        'cf_id',
    	'date',
        'cashier_name',
        'bar_tender_name',
        'shifting_schedule',
        'starting_os',
        'cash_sales',
        'credit_card_sales',
        'signing_privilage_sales',
        'total_reading',
        'closing_os',
        'items',
        'opening_inventory',
        'sold',
        'closing',
        'total',
        'created_by',
    ];
}
