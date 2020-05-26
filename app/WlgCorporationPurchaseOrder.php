<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WlgCorporationPurchaseOrder extends Model
{
    //
    protected $fillable = [
		'user_id',
		'paid_to',
		'po_id',
		'p_o_number',
		'address',
        'date',
        'model',
		'particulars',
		'quantity',
		'unit_price',
		'amount',
		'prepared_by',
		'checked_by',
		'created_by',
	];
}
