<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoloPinoyGrillCommissaryStatementOfAccount extends Model
{
    //
     protected $fillable = [
		'user_id',
		'soa_id',
		'billing_statement_id',
		'bs_no',
		'order',
		'dr_no',
		'dr_list_id',
		'product_id',
		'qty',
		'unit',
		'invoice_list_id',
		'total_kls',
		'total_amount',
		'total_remaining_balance',
		'date',
		'branch',
		'bill_to',
		'address',
		'period_cover',
		'date_of_transaction',
		'description',
		'invoice_number',
		'kilos',
		'unit_price',
		'payment_method',
		'amount',
		'status',
		'terms',
		'paid_amount',
		'collection_date',
		'check_number',
		'check_amount',
		'or_number',
		'amount_statement_account',
		'created_by',

		
    ];
}
