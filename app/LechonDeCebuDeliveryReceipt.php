<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LechonDeCebuDeliveryReceipt extends Model
{
    //
    protected $fillable = [
    	'user_id',
    	'dr_id',
    	'sold_to',
    	'delivered_to',
    	'time',
    	'dr_no',
    	'date',
        'date_to_be_delivered',
    	'contact_person',
    	'mobile_num',
    	'qty',
    	'description',
    	'price',
    	'total',
    	'special_instruction',
        'consignee_name',
        'consignee_contact_num',
    	'prepared_by',
    	'checked_by',
    	'received_by',
    	'created_by',
        'duplicate_status',
    ];
}
