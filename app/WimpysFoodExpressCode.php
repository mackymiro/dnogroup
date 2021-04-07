<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WimpysFoodExpressCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'wimpys_food_express_code',
        'cbf_no',
        'module_id',
        'module_code',
        'module_name',
    ];
    
}
