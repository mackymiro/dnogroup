<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'photo', 
        'email', 
        'password',
        'role_type',
        'select_branch',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /*public function delivery_receipts(){
        return $this->hasMany('App\DnoFoodVenturesDeliveryReceipt');
    }*/

    public function dno_food_ventures_raw_material_products(){
        return $this->hasMany('App\DnoFoodVenturesRawMaterialProduct');
    }




}
