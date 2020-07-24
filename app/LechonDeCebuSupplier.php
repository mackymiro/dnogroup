<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LechonDeCebuSupplier extends Model
{
    //
    protected $fillable = [
        'user_id',
        's_id',
        'date',
        'supplier_name',
        'created_by',
    ];
}
