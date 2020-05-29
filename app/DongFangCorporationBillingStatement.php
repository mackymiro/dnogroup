<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DongFangCorporationBillingStatement extends Model
{
    //
    protected $fillable = [
        'user_id',
        'bs_id',
        'date',
        'account_no',
        'company_name',
        'address',
        'billing_statement_no',
        'attention',
        'ref_no',
        'po_no',
        'terms',
        'due_date',
        'date_detail',
        'no_pax',
        'particular',
        'price_per_pax',
        'amount',
        'created_by',
    ];
}
