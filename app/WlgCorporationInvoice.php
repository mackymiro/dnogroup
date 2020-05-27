<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WlgCorporationInvoice extends Model
{
    //
    protected $fillable = [
        'user_id',
        'if_id',
        'date',
        'delivery_terms',
        'transport_by',
        'invoice_number',
        'shipper',
        'consignee',
        'notify_party',
        'attention',
        'number_of_goods',
        'description_of_goods',
        'qty',
        'unit_price',
        'total_amount',
        'status',
        'created_by',
    ];
}
