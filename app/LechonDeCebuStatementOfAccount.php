<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LechonDeCebuStatementOfAccount extends Model
{
    //

    protected $fillable = [
		'user_id',
		'billing_statement_id',
		'bill_to',
		'date',
		'address',
		'period_cover',
		'reference_number',
		'p_o_number',
		'terms',
		'transaction_date',
		'branch',
		'invoice_number',
		'whole_lechon',
		'description',
		'invoice_number_soa',
		'payment_method',
		'status',
		'paid_amount',
		'collection_date',
		'check_number',
		'check_amount',
		'or_number',
		'created_by',
		'amount',
		'amount_statement_account',
    ];
}
