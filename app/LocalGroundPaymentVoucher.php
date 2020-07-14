<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalGroundPaymentVoucher extends Model
{
    //
    protected $fillable = [
        'user_id',
        'pv_id',
        'reference_number',
        'date',
        'paid_to',
        'account_no',
        'account_name',
        'particulars',
        'amount',
        'method_of_payment',
        'prepared_by',
        'approved_by',
        'date_approved',
        'received_by_date',
        'invoice_number',
        'voucher_ref_number',
        'issued_date',
        'category',
        'sub_category',
        'sub_category_account_id',
        'amount_due',
        'delivered_date',
        'status',
        'account_name_no',
        'cheque_number',
        'cheque_amount',
        'cheque_total_amount',
        'created_by',

    ];
}
