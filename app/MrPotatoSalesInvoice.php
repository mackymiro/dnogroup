<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MrPotatoSalesInvoice extends Model
{
	use SoftDeletes;
	
	protected $dates = ['deleted_at'];

	protected $fillable = [
	'user_id',
	'si_id',
	'invoice_number',
	'date',
	'ordered_by',
	'address',
	'qty',
	'total_kls',
	'item_description',
	'unit_price',
	'amount',
	'total_amount',
	'created_by',
    ];
}
