<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DnoPersonalPaymentVoucher extends Model
{
      use SoftDeletes;
	
      protected $dates = ['deleted_at'];
      
      protected $fillable = [
    	'user_id',
        'pv_id',
        'reference_number',
        'date',
        'paid_to',
        'bank_card',
        'account_no',
        'account_name',
        'category',
        'use_credit_card',
        'sub_category',
        'sub_category_name',
        'sub_category_bill_name',
        'sub_category_account_id',
        'supplier_id',
        'supplier_name',
        'particulars',
        'amount',
        'currency',
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
        'account_name_no',
        'cheque_number',
        'cheque_amount',
        'cheque_total_amount',
        'type_of_card',
        'utility_sub_category',
        'utility_sub_category_name',
    ];
}
