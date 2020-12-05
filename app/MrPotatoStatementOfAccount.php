<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MrPotatoStatementOfAccount extends Model
{
    //
    protected $fillable = [
        'user_id',
        'soa_id',
        'billing_statement_id',
        'bs_no',
        'date',
        'branch',
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
        'invoice_number',
        'unit_price',
        'unit',
        'payment_method',
        'amount',
        'total_amount',
        'total_remaining_balance',
        'status',
        'terms',
        'paid_amount',
        'collection_date',
        'check_number',
        'check_amount',
        'or_number',
        'created_by',
    ];
}
