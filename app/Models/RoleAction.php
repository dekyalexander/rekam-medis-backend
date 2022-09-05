<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleAction extends Pivot
{
    protected $connection   = 'pusat';
    
    protected $table = 'role_actions';
   
   
}