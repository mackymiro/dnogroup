<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoPersonalCreditCard extends Model
{
    //
    protected $fillable = [
        'user_id',
        'bank_name',
        'account_no',
        'account_name',
        'type_of_card',
        'created_by',
 	];
}
