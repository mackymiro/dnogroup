<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoloPinoyGrillBranchesSalesForm extends Model
{
    use SoftDeletes;
	
    protected $dates = ['deleted_at'];

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
        'senior_citizen_label',
        'senior_citizen_id',
        'senior_citizen_name',
        'senior_amount',
        'senior_discount',
        'total_amount_of_sales',
        'total',
        'gift_cert',
        'cash_amount',
        'change',
        'flag',
        'created_by',
    ];
}

