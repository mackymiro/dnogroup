<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RibosBarSalesInvoice extends Model
{
    //
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
