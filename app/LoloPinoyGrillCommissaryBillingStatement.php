<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoloPinoyGrillCommissaryBillingStatement extends Model
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
    	'date_of_transaction',
    	'invoice_number',
    	'whole_lechon',
    	'description',
		'amount',
		'total_amount',
    	'prepared_by',
    	'approved_by',
    	'created_by',
        'payment_method',
        'status',
        'paid_amount',
        'collection_date',
        'check_number',
        'check_amount',
        'or_number',
    ];
}
