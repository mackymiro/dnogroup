<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoFoodVenturesCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'dno_food_venture_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
