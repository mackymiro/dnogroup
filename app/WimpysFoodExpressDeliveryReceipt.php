<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WimpysFoodExpressDeliveryReceipt extends Model
{
    //
    use SoftDeletes;
	
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'user_id',
        'dr_id',
        'sold_to',
        'delivered_to',
    	'time',
    	'dr_no',
    	'date',
		'date_to_be_delivered',
		'delivered_for',
    	'contact_person',
		'mobile_num',
		'product_id',
		'qty',
		'unit',
		'unit_price',
    	'description',
    	'price',
    	'total',
    	'special_instruction',
        'consignee_name',
		'consignee_contact_num',
		'status',
    	'prepared_by',
    	'checked_by',
    	'received_by',
    	'created_by',
    ];

}
