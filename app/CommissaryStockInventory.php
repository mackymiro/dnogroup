<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissaryStockInventory extends Model
{
    //
	protected $fillable = [
		'user_id',
		'branch',
		'product_id_no',
		'product_name',
		'unit_price',
		'unit',
		'in',
		'out',
		'remaining_stock',
		'amout',
		'supplier',
		'created_by',

 	];
}
