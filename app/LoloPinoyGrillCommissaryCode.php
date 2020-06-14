<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoloPinoyGrillCommissaryCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'lolo_pinoy_grill_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
