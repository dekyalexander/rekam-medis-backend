<?php

namespace App\Repositories;

use App\Models\UKSOfficerRegistration;
use App\Models\ListOfUKSLocations;
use Carbon\Carbon;

class UKSOfficerRegistrationRepository{
  protected $uksofficerregistration;

  public function __construct(UKSOfficerRegistration $uksofficerregistration){
    $this->uksofficerregistration = $uksofficerregistration;
  }

  public function getListUKSLocationById($id,$selects=['*']){
    return ListOfUKSLocations::select($selects)
    ->where('id','=',$id);
  }

  public function getOfficerRegistrationById($id,$selects=['*']){
    return UKSOfficerRegistration::select($selects)
    ->where('id','=',$id);
  }

  public function getListUKSLocationOptions($filters){
    return ListOfUKSLocations::select('id','uks_name')
    ->when(isset($filters['uks_name']), function ($query) use ($filters) {
      return $query->where('uks_name','like','%'.$filters['uks_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }

  public function getUKSOfficerRegistrationOptions($filters){
    return UKSOfficerRegistration::select('id','name','job_location_id','created_at')
    ->with(['listofukslocations'=>function($query){
      $query->select('id', 'uks_name');
    }])
    ->when(isset($filters['id']), function ($query) use ($filters) {
    return $query->where('id','=',$filters['id']);
    })
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    });
  }

  // public function getUKSOfficerRegistrationByCode($officername,$joblocationid){
  //   return UKSOfficerRegistration::
  //   where('name','=',$officername)
  //   ->where('job_location_id','=',$joblocationid)
  //   ->count();
  // } 

  // public function getUKSOfficerRegistrationOptions($filters){
  //   return UKSOfficerRegistration::select('id','officer_name','job_location','created_at')
  //   ->when(isset($filters['officer_name']), function ($query) use ($filters) {
  //     return $query->where('officer_name','like','%'.$filters['officer_name'].'%');
  //   })
  //   ->when(isset($filters['id']), function ($query) use ($filters) {
  //     return $query->where('id','=',$filters['id']);
  //   });
  // }

  public function insert($data){
    UKSOfficerRegistration::insert($data);
  }

  public function updateUKSOfficerRegistration($data,$id){
    UKSOfficerRegistration::where('id', $id)
            ->update($data);
  }
  
  public function deleteUKSOfficerRegistration($ids){
    UKSOfficerRegistration::whereIn('id', $ids)
            ->delete();
  }

}
