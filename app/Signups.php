<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    //
}
<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signup extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='signups';
}
        