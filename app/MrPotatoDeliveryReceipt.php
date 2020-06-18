<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MrPotatoDeliveryReceipt extends Model
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
		'amount',
		'total_amount',
    	'prepared_by',
        'approved_by',
    	'checked_by',
    	'received_by',
    	'created_by',
        'duplicate_status',
    ];
}
