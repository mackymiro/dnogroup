<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoFoodVenturesStatementOfAccount extends Model
{
    //

    protected $fillable = [
        'user_id',
        'billing_statement_id',
        'bs_no',
        'bill_to',
        'date',
        'address',
        'period_cover',
        'terms',
        'date_of_transaction',
        'invoice_number',
        'order',
        'dr_no',
        'dr_list_id',
        'product_id',
        'qty',
        'unit_price',
        'unit',
        'total_kls',
        'invoice_list_id',
        'description',
        'amount',
        'total_amount',
        'total_remaining_balance',
        'branch',
        'prepared_by',
        'approved_by',
        'paid_amount',
        'payment_method',
        'status',
        'collection_date',
        'check_number',
        'check_amount',
        'or_nunmber',
        'created_by',
    ];

    public function user(){
        return $this->belongsTo('App\User');

    }   
    
    public function statement_of_accounts(){
        return $this->hasMany('App\DnoFoodVenturesCode', 'module_id');
    }

}
