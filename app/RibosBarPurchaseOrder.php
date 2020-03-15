<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RibosBarPurchaseOrder extends Model
{
    //

    protected $fillable = [
		'user_id',
		'paid_to',
		'po_id',
		'p_o_number',
		'address',
		'date',
		'quantity',
		'description',
		'unit_price',
		'amount',
		'total_price',
		'created_by',
	];
}
