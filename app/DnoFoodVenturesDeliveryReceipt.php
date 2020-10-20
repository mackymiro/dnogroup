<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DnoFoodVenturesDeliveryReceipt extends Model
{
    //

    use SoftDeletes;
	
    protected $dates = ['deleted_at'];
    
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
	];
	
	public function user(){
		return $this->belongsTo('App\User');
	}

	public function delivery_receipts(){
		return $this->hasMany('App\DnoFoodVenturesCode', 'module_id');
	}


}
