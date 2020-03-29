<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoloPinoyGrillBranchesRequisitionSlip extends Model
{
    //
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
