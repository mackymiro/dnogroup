<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LechonDeCebuPurchaseOrder extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $fillable = [
		'user_id',
		'paid_to',
		'po_id',
		'p_o_number',
		'address',
		'date',
		'quantity',
		'total_kls',
		'description',
		'unit_price',
		'amount',
		'total_price',
		'created_by',
	];
}
