<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WimpysFoodExpressMenuList extends Model
{
    //

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'created_by',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
