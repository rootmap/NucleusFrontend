<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouldBoostProfitability extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='could_boost_profitabilities';
}
        