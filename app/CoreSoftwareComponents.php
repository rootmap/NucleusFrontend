<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoreSoftwareComponents extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='core_software_componentses';
}
        