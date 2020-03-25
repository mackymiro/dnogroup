<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoloPinoyGrillCommissaryRawMaterial extends Model
{
    //
     protected $fillable = [
		'user_id',
		'rm_id',
		'branch',
		'product_id_no',
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
}
