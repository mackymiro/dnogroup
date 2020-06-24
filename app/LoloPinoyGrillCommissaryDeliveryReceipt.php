<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoloPinoyGrillCommissaryDeliveryReceipt extends Model
{
    //
     protected $fillable = [
    	'user_id',
    	'dr_id',
    	'sold_to',
    	'delivered_to',
    	'dr_no',
    	'date',
        'product_id',
    	'qty',
        'unit',
    	'item_description',
		'unit_price',
		'address',
		'amount',
		'total_amount',
		'charge_to',
		'address_to',
    	'prepared_by',
        'approved_by',
    	'checked_by',
    	'received_by',
    	'created_by',
        'duplicate_status',
    ];
}
