<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DnoFoundationIncPurchaseOrder extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
		'user_id',
		'paid_to',
		'po_id',
		'p_o_number',
		'address',
		'date',
		'quantity',
		'total_kls',
		'description',
		'unit_price',
		'amount',
		'total_price',
		'created_by',
	];

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function purchase_orders(){
		return $this->hasMany('App\DnoFoundationIncCode',  'module_id');
	}
}
