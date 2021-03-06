<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoloPinoyGrillBranchesStoreStock extends Model
{
    //
    protected $fillable = [
        'user_id',
        'di_id',
        'date',
        'dr_no',
        'supplier',
        'product_name',
        'price',
        'qty',
        'unit',
        'product_in',
        'product_out',
        'amount',
        'branch',
        'flag',
        'created_by',
    ];
}
