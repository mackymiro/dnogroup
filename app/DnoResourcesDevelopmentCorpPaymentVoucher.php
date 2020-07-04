<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DnoResourcesDevelopmentCorpPaymentVoucher extends Model
{
     use SoftDeletes;

     protected $dates = ['deleted_at'];
    
     protected $fillable = [
    	'user_id',
        'pv_id',
        'reference_number',
        'date',
        'paid_to',
        'account_no',
        'account_name',
        'category',
        'sub_category',
        'sub_category_account_id',
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
        'cheque_total_amount',
    ];
}
