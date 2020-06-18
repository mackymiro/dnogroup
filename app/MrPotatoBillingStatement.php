<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MrPotatoBillingStatement extends Model
{
    //
    protected $fillable = [
        'user_id',
        'billing_statement_id',
        'date',
        'bill_to',
        'address',
        'period_covered',
        'terms',
        'date_of_transaction',
        'order',
        'invoice_no',
        'invoice_list_id',
        'qty',
        'total_kls',
        'item_description',
        'unit_price',
        'amount',
        'dr_no',
        'dr_list_id',
        'product_id',
        'unit',
        'created_by',
    ];
}
