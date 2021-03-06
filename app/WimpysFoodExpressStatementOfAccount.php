<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WimpysFoodExpressStatementOfAccount extends Model
{
    //

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'user_id',
        'billing_statement_id',
        'bs_no',
        'bill_to',
        'date',
        'period_cover',
        'terms',
        'date_of_transaction',
        'order',
        'date_of_event',
        'time_of_event',
        'no_of_people',
        'motiff',
        'type_of_package',
        'client',
        'place_of_event',
        'dr_list_id',
        'qty',
        'unit',
        'price',
        'dr_no',
        'description',
        'unit_price',
        'amount',
        'total_amount',
        'total_remaining_balance',
        'amount_statement_account',
        'paid_amount',
        'collection_date',
        'check_number',
        'check_amount',
        'status',
        'payment_method',
        'or_number',
        'prepared_by',
        'approved_by',
        'created_by',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function statement_of_accounts(){
        return $this->hasMany('App\WimpysFoodExpressCode', 'module_id');
    }
}
