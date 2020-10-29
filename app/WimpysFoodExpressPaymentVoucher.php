<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WimpysFoodExpressPaymentVoucher extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
    	'user_id',
        'pv_id',
    	'reference_number',
    	'date',
    	'paid_to',
    	'account_no',
    	'particulars',
    	'amount',
    	'method_of_payment',
    	'prepared_by',
    	'approved_by',
    	'date_approved',
    	'received_by_date',
    	'created_by',
        'invoice_number',
        'issued_date',
        'amount_due',
        'delivered_date',
		'status',
		'account_name_no',
        'cheque_number',
		'cheque_amount',
		'cheque_total_amount',
		'category',
		'sub_category',
		'sub_category_account_id',
		'supplier_id',
		'supplier_name',
		'account_name',
	];
	

	public function user(){
		return $this->belongsTo('App\User');
		
	}

	public function payment_vouchers(){
		return $this->hasMany('App\WimpysFoodExpressCode',  'module_id');
	}


}
