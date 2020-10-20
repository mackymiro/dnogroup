<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RibosBarBillingStatement extends Model
{
    //
    protected $fillable = [
    	'user_id',
    	'billing_statement_id',
    	'bill_to',
    	'address',
    	'date',
    	'reference_number',
    	'p_o_number',
    	'period_cover',
		'terms',
		'order',
		'dr_no',
		'dr_list_id',
		'product_id',
		'qty',
		'unit',
		'unit_price',
		'total_kls',
		'invoice_list_id',
		'branch',
		'paid_amount',
		'check_number',
		'check_amount',
		'or_number',
    	'date_of_transaction',
    	'invoice_number',
    	'whole_lechon',
    	'description',
    	'amount',
    	'prepared_by',
    	'approved_by',
    	'created_by',
    ];
}
