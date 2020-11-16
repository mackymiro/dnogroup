<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WimpysFoodExpressStockInventory extends Model
{
    //
    protected $fillable = [
        'user_id',
        'product_name',
        'unit',
        'price',
        'category',
        'created_by',
    ];
    
}

