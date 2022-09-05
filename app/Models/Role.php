<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'data_access_value',
        'role_level_value',
        'unit_id',
        'head_role_id',
        'unit_type_value',
        'is_head',
        'subtitute_role_id',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function applications() {
        return $this->belongsToMany(Application::class, 'role_applications', 'role_id', 'application_id');
    } 

    public function menus() {
        return $this->belongsToMany(Menu::class, 'role_menus', 'role_id', 'menu_id');
    } 

    public function actions() {
        return $this->belongsToMany(Action::class, 'role_actions', 'role_id', 'action_id');
    }
    
    public function approvals() {
        return $this->belongsToMany(Action::class, 'role_approval', 'role_id', 'action_id');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
    } 

    public function head_role() {
        return $this->belongsTo(Role::class, 'head_role_id', 'id');
    } 

    public function data_access() {
        return $this->belongsTo(Parameter::class, 'data_access_value', 'value')->where('group','data_access');;
    } 

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    // public function unit_type(){
    //     return $this->belongsTo('App\Models\Parameter','value','unit_id')->where('group','unit_type');
    // }
    
}
