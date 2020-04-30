<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DnoPersonalUtility extends Model
{
    //
    protected $fillable = [
        'user_id',
        'pu_id',
        'vehicle_unit',
        'series',
        'denomination',
        'body_type',
        'year_model',
        'mv_file_no',
        'plate_no',
        'engine_no',
        'cr_no',
        'location',
        'document_name',
        'flag',
        'upload_document',
        'upload_pms_document',
        'date',
        'created_by',

    ];
}
