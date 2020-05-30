<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LechonDeCebuPaymentVoucher extends Model
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
        'invoice_number',
        'voucher_ref_number',
        'issued_date',
        'amount_due',
        'delivered_date',
        'status',
        'cheque_number',
        'cheque_amount',
		'category',
		'sub_category',
		'sub_category_account_id',
		'account_name',
    ];
}
