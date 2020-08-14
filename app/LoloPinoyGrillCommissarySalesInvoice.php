<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoloPinoyGrillCommissarySalesInvoice extends Model
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
		'item_description',
		'unit_price',
		'amount',
		'created_by',
    ];
}
