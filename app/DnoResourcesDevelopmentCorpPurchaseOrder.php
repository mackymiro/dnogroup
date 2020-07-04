<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DnoResourcesDevelopmentCorpPurchaseOrder extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];
	
    protected $fillable = [
		'user_id',
		'paid_to',
		'po_id',
		'p_o_number',
		'address',
		'branch_location',
		'ordered_by',
		'particulars',
		'qty',
		'unit',
		'price',
		'subtotal',
		'date',
		'quantity',
		'description',
		'unit_price',
		'amount',
		'total_price',
		'prepared_by',
		'checked_by',
		'created_by',
	];
}
