<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoloPinoyGrillCommissaryPurchaseOrder extends Model
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
		'description',
		'unit_price',
		'amount',
		'total_price',
		'prepared_by',
		'checked_by',
		'requesting_branch',
		'created_by',
	];
}
