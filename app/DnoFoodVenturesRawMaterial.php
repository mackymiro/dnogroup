<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoFoodVenturesRawMaterial extends Model
{
    //
    protected $fillable = [
		'user_id',
		'rm_id',
		'product_name',
		'unit_price',
		'unit',
		'in',
		'out',
		'stock_amount',
		'remaining_stock',
		'amount',
		'supplier',
		'date',
		'item',
		'description',
		'reference_no',
		'qty',
		'requesting_branch',
		'cheque_no_issued',
		'status',
		'created_by',
		'remarks',
	 ];

	 
	 public function user(){
		 return $this->belongsTo('App\User');
	 }

	 public function raw_material_product(){
		return $this->belongsTo('App\DnoFoodVenturesRawMaterialProduct', 'id');
	 }	

	
}
