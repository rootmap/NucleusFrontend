<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PowerfulCapabilities extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='powerful_capabilitieses';
}
        