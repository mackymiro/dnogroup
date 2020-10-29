<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WimpysFoodExpressSupplier extends Model
{
    //
    protected $fillable = [
        'user_id',
        's_id',
        'date',
        'supplier_name',
        'created_by',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function suppliers(){
        return $this->hasMany('App\WimpysFoodExpressPaymentVoucher', 'supplier_id');
    }
}
