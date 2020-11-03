<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DnoResourcesDevelopmentCorpBillingStatement extends Model
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
        return $this->hasMany('App\DnoResourcesDevelopmentCode', 'module_id');

    }
}
