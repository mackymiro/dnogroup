<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WimpysFoodExpressOrderForm extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'order_id',
        'date',
        'time',
        'no_of_people',
        'items',
        'qty',
        'unit',
        'price',
        'total',
        'created_by',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }


    
}
