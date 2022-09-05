<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection   = 'pusat';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'username',
        'emp_id',
        'emp_status',
        'user_type_value',
        'user_unit'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_type(){
        return $this->belongsTo('App\Models\Parameter', 'user_type_value','value')->where('group','user_type');
    }

    public function roles() {
        return $this->belongsToMany(Role::class //class model yang mau di ambil;
            , 'role_users' //tabel yang berelasi dengan table Role dan table User
            , 'user_id'//key role_users from this class
            , 'role_id'//key role_users from this class Role
        );
    } 

    public function employee(){
        return $this->hasOne('App\Models\Employee', 'user_id');
    }

    public function student(){
        return $this->hasOne('App\Models\Student', 'user_id');
    }

    public function parent(){
        return $this->hasOne('App\Models\Parents', 'user_id');
    }

    public function applications() {
        return $this->belongsToMany(Application::class
            , 'role_users'
            , 'user_id'
            , 'role_id'
        );
    } 

    public function units() {
        return $this->belongsToMany(Unit::class 
            , 'user_units' 
            , 'user_id'
            , 'unit_id'
        );
    } 

   


    
}
