<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoResourcesDevelopmentCorpDeliveryTransactionForm extends Model
{
    //
    protected $fillable = [
        'user_id',
        'dt_id',
        'supplier_name',
        'delivery_date',
        'delivered_to',
        'dr_no',
        'delivery_description',
        'qty',
        'total',
        'created_by',
    ];
}
