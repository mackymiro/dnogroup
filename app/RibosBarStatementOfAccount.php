<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RibosBarStatementOfAccount extends Model
{
    //

     protected $fillable = [
		'user_id',
		'soa_id',
		'billing_statement',
		'bs_no',
		'bill_to',
		'address',
		'period_cover',
		'date_of_transaction',
		'description',
		'order',
		'dr_no',
		'dr_list_id',
		'invoice_list_id',
		'total_kls',
		'product_id',
		'qty',
		'unit',
		'total_amount',
		'total_remaining_balance',
		'terms',
		'date',
		'branch',
		'invoice_number',
		'kilos',
		'unit_price',
		'payment_method',
		'amount',
		'status',
		'paid_amount',
		'collection_date',
		'check_number',
		'check_amount',
		'or_number',
		'created_by',
    ];
}
