<?php

namespace App\Repositories;

use App\Models\BloodGroup;
use Carbon\Carbon;

class BloodGroupRepository{
  protected $bloodgroup;

  public function __construct(BloodGroup $bloodgroup){
    $this->bloodgroup = $bloodgroup;
  }

  public function getBloodGroupById($id,$selects=['*']){
    return BloodGroup::select($selects)
    ->where('id','=',$id);
  }

  public function getBloodGroupOptions($filters){
    return BloodGroup::select('id','blood_name')
    ->when(isset($filters['blood_name']), function ($query) use ($filters) {
      return $query->where('blood_name','like','%'.$filters['blood_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }

}
