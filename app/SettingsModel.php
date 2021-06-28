<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    //
    protected $fillable = [
        'settings_for_body',
        'settings_head_feet',
    ];
}
