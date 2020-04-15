<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatMakesBetter extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='what_makes_betters';
}
        