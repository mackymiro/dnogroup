<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RibosBarPaymentVoucher extends Model
{
    //
      protected $fillable = [
    	'user_id',
        'pv_id',
    	'reference_number',
    	'date',
    	'paid_to',
    	'account_no',
    	'particulars',
    	'amount',
    	'method_of_payment',
    	'prepared_by',
    	'approved_by',
    	'date_approved',
    	'received_by_date',
    	'created_by',

    ];
}
