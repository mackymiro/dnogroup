<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoloPinoyGrillBranchesStockInventory extends Model
{
    //
    protected $fillable = [
        'user_id',
        'transaction_id',
        'date',
        'product_name',
        'flavor',
        'price',
        'opening_stock',
        'product_in',
        'product_out',
        'sold',
        'remaining_stock',
        'amount',
        'flag',
        'branch',
    ];
}
