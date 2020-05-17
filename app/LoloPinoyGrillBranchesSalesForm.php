<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoloPinoyGrillBranchesSalesForm extends Model
{
    //
    protected $fillable = [
        'user_id',
        'sf_id',
        'invoice_number',
        'ordered_by',
        'table_no',
        'date',
        'branch',
        'qty',
        'item_description',
        'amount',
        'total_discounts_seniors_pwds',
        'total_amount_of_sales',
        'gift_cert',
        'cash_amount',
        'change',
        'created_by',
    ];
}

