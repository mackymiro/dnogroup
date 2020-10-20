<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DnoFoodVenturesSalesInvoice extends Model
{
    //
    use SoftDeletes;
	
	protected $dates = ['deleted_at'];

    protected $fillable = [
		'user_id',
		'si_id',
		'invoice_number',
		'sales_invoice_number',
		'date',
		'ordered_by',
		'address',
		'qty',
		'total_kls',
		'item_description',
		'unit_price',
		'amount',
		'created_by',
	];
	
	public function user(){
		return $this->belongsTo('App\User');
	}

	public function sales_invoices(){
		return $this->hasMany('App\DnoFoodVenturesCode', 'module_id');
	}

}
