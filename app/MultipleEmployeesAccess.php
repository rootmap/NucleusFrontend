<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MultipleEmployeesAccess extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='multiple_employees_accesses';
}
        