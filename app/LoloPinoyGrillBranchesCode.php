<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoloPinoyGrillBranchesCode extends Model
{
    //
    protected $fillable = [
        'user_id',
        'lolo_pinoy_branches_code',
        'module_id',
        'module_code',
        'module_name',
    ];
}
