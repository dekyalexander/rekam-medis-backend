<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
  use HasFactory;

  protected $connection   = 'pusat';
  
  protected $fillable = [
    'name',
    'ip',
    'host',
    'code',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  public function menus(){
    return $this->hasMany(Menu::class, 'application_id', 'id');
  }
  
  public function roles() {
    return $this->belongsToMany(Role::class, 'role_applications', 'application_id', 'role_id');
  } 


  public function categoryApp()
  {
    return $this->hasMany(ApplicationCategories::class, 'application_id', 'id');
  }

}
