<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LechonDeCebuStatementOfAccount extends Model
{
    //

    protected $fillable = [
		'user_id',
		'date',
		'branch',
		'invoice_number',
		'kilos',
		'unit_price',
		'payment_method',
		'amount',
		'status',
		'paid_amount',
		'collection_date',
		'check_number',
		'check_amount',
		'or_number',
		'created_by',
    ];
}
