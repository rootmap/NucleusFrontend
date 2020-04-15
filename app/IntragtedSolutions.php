<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntragtedSolutions extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='intragted_solutionses';
}
        