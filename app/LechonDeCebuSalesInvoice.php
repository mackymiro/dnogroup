<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LechonDeCebuSalesInvoice extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $fillable = [
		'user_id',
		'si_id',
		'invoice_number',
		'sales_invoice_number',
		'date',
		'ordered_by',
		'address',
		'qty',
		'total_kls',
		'body',
		'head_and_feet',
		'item_description',
		'unit_price',
		'amount',
		'total_amount',
		'created_by',
    ];
}

