<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SignupPackage extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='signup_packages';
}
        