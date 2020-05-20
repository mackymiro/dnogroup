<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoPersonalPaymentVoucher extends Model
{
    //
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
        'type_of_card',
        'utility_sub_category',
        'utility_sub_category_name',
    ];
}
