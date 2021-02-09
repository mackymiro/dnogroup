<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WimpysFoodExpressBillingStatement extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'user_id',
    	'billing_statement_id',
    	'bill_to',
    	'address',
    	'date',
    	'period_cover',
        'terms',
		'unit_price',
		'paid_amount',
		'check_number',
		'check_amount',
		'or_number',
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
		'amount',
		'total_amount',
    	'prepared_by',
    	'approved_by',
    	'created_by',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function billing_statements(){
        return $this->hasMany('App\WimpysFoodExpressCode', 'module_id');   
    }
}
