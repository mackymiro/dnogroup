<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LechonDeCebuSalesInvoice extends Model
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
		'body',
		'head_and_feet',
		'item_description',
		'unit_price',
		'amount',
		'created_by',
    ];
}

