<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LechonDeCebuBillingStatement extends Model
{
    //

    protected $fillable = [
    	'user_id',
    	'billing_statement_id',
    	'bill_to',
    	'address',
    	'date',
    	'soa_number',
    	'p_o_number',
    	'period_cover',
    	'terms',
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
