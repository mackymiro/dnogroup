<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoloPinoyGrillBranchesRequisitionSlip extends Model
{
      use SoftDeletes;
	
      protected $dates = ['deleted_at'];


      protected $fillable = [
    	'user_id',
        'rs_id',
        'rs_number',
        'requesting_department',
        'request_date',
        'date_released',
        'quantity_requested',
        'unit',
        'item',
        'quantity_given',
        'released_by',
        'received_by',
        'created_by',
    
    ];
}
