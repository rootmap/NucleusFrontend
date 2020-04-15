<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimpleCashRegister extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='simple_cash_registers';
}
        