<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseHardware extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='purchase_hardwares';
}
        