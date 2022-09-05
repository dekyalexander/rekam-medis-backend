<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    protected $connection   = 'pusat';
    
    protected $table = 'role_users';

   
}