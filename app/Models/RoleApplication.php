<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleApplication extends Model
{
    use HasFactory;

    protected $connection   = 'pusat';
    
    protected $table = 'role_applications';


    protected $fillable = [
        'role_id',
        'application_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function application(){
        return $this->hasOne(Application::class, 'id', 'application_id');
    }

}