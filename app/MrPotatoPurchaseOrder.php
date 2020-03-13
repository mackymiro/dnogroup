<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MrPotatoPurchaseOrder extends Model
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
		'prepared_by',
		'checked_by',
		'created_by',
	];
}
