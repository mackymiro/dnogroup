<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoPersonalSupplier extends Model
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
