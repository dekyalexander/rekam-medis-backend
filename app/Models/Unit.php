<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'head_role_id',
        'unit_type_value',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
  public function roles()
  {
    return $this->hasMany(Role::class, 'unit_id', 'id');
  }

  // public function unit_type(){
  //   return $this->belongsTo('App\Models\Parameter','id','value')->where('group','unit_type');
  //   return $this->belongsTo('App\Models\Parameter','value', 'id')->where('group','unit_type');
  // }


  public function unit_type(){
    return $this->belongsTo('App\Models\Parameter', 'unit_type_value','value')->where('group','unit_type');
}


}
