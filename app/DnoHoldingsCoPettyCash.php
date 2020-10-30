<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DnoHoldingsCoPettyCash extends Model
{
    //
    use SoftDeletes;
	
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'user_id',
        'pc_id',
        'petty_cash_no',
        'date',
        'petty_cash_name',
        'petty_cash_summary',
        'amount',
        'created_by',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function petty_cashes(){
        return $this->hasMany('App\DnoHoldingsCoCode', 'module_id');
    }
}
