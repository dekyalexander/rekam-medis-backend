<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleMenu extends Pivot
{
    
    protected $table = 'role_menus';
    

    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function menu(){
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }

}