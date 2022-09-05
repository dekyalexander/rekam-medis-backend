<?php

namespace App\Repositories;

use App\Models\ListOfUKSLocations;
use App\Models\Drug;
use Carbon\Carbon;

class DrugLocationRepository{
  protected $druglocation;

  public function __construct(ListOfUKSLocations $druglocation){
    $this->druglocation = $druglocation;
  }

  public function getDrugLocationById($id,$selects=['*']){
    return ListOfUKSLocations::select($selects)
    ->where('id','=',$id);
  }

  public function getDrugLocationByCode($druglocation){
    return ListOfUKSLocations::
    where('uks_name','=',$druglocation)
    ->count();
  } 

  public function getDrugLocationOptions($filters){
    $location_id = $filters['id'];
    $query =  ListOfUKSLocations::select('id', 'uks_name','created_at')
    ->with(['drugdistribution.drugname'=>function($query){
      $query->select('id', 'drug_name');
    }])
    ->with(['drugdistribution.drugunit'=>function($query){
      $query->select('id', 'drug_unit');
    }])
    ->with(['drugdistribution.drugexpired'=>function($query){
      $query->select('id', 'date_expired');
    }])
    ->when(isset($filters['uks_name']), function ($query) use ($filters) {
      return $query->where('uks_name','like','%'.$filters['uks_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
        return $query->Where('id', $filters['id']);
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    })->orderBy('uks_name');

    if($location_id != null)
    $query->WhereHas('drugdistribution', function ($q) use($location_id) {
        return $q->where('id', '=', $location_id);
    });


   return $query;
  }

  public function insert($data){
    ListOfUKSLocations::insert($data);
  }

  public function updateDrugLocation($data,$id){
    ListOfUKSLocations::where('id', $id)
            ->update($data);
  }
  
  public function deleteDrugLocation($ids){
    ListOfUKSLocations::whereIn('id', $ids)
            ->delete();
  }


}
