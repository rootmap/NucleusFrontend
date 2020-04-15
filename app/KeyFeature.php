<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeyFeature extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='key_features';
}
        