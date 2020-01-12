<?php

namespace App\admin\Models;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Scan extends Model
{
    use UsesTenantConnection;

}
