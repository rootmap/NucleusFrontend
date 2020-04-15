<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemEasytoUse extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='system_easy_to_uses';
}
        