<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RibosBarRawMaterialProduct extends Model
{
    //
    protected $fillable = [
        'raw_materials_id',
        'branch',
        'product_id_no',
    ];
}

