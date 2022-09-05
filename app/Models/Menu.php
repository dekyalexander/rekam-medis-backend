<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  use HasFactory;

  protected $connection   = 'pusat';

  protected $fillable = [
    'name',
    'application_id',
    'is_head',
    'is_menu_id',
    'path',
    'icon',
    'created_at',
    'updated_at',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  public function parent() {
    return $this->belongsTo(Menu::class, 'parent_id');
  } 

  public function children() {
    return $this->hasMany(Menu::class, 'parent_id');
  } 

  public function application() {
    return $this->hasOne(Application::class, 'id', 'application_id');
  } 

  public function actions() {
    return $this->hasMany(Action::class, 'menu_id', 'id');
  } 
  
  public function roles() {
    return $this->belongsToMany(Role::class, 'role_menus', 'menu_id', 'role_id');
  }
}
