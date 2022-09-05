<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Action extends Model
{
  use HasFactory;

  protected $connection   = 'pusat';

  protected $fillable = [
    'code',
    'name',
    'menu_id',
    'application_id',
    'need_approval',
    'description',
    'approval_type_value',
    'created_at',
    'updated_at',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  public function menus()
  {
    return $this->hasMany(Menu::class, 'id', 'menu_id');
  }

  public function menu()
  {
    return $this->belongsTo(Menu::class, 'menu_id', 'id');
  }

  public function application()
  {
    return $this->belongsTo(Application::class, 'application_id', 'id');
  }

  public function role_level()
  {
    return $this->belongsTo(Parameter::class, 'role_level_value', 'value')->where('group','role_level');
  }
  


  public function roles() {
    return $this->belongsToMany(Role::class, 'role_actions', 'action_id', 'role_id');
  }

  public function approvals() {
    return $this->belongsToMany(Role::class, 'role_approval', 'action_id', 'role_id');
  }
  
}
