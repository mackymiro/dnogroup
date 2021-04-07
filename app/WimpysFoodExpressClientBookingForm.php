<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WimpysFoodExpressClientBookingForm extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    //
    protected $fillable = [
        'user_id',
        'bf_id',
        'date_of_event',
        'time_of_event',
        'no_of_people',
        'motiff',
        'qty',
        'item',
        'description',
        'less',
        'downpayment',
        'amount',
        'type_of_package',
        'total',
        'client',
        'place_of_event',
        'mobile_number',
        'email',
        'special_requests',
        'menu',
        'menu_cat',
        'created_by',
    ];

    public function user(){
		return $this->belongsTo('App\User');
		
    }
    
    public function client_bookings(){
        return $this->hasMany('App\WimpysFoodExpressCode',  'module_id');
    }
}
