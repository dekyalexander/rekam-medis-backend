<?php

namespace App\Repositories;

use App\Models\Parents;
use App\Models\Student;
use Carbon\Carbon;

class ParentRepository{
  protected $parent;

  public function __construct(Parents $parent){
    $this->parent = $parent;
  }

  public function getParentById($id,$selects=['*']){
    return Parents::select($selects)
    ->where('id','=',$id);
  }

  public function getParentDetail($parent_id){
    return Parents::
    with([
      'user',
      'sex_type:parameters.value,parameters.name',
      'parent_type:parameters.value,parameters.name',
      'wali_type:parameters.value,parameters.name'])
    ->where('id','=',$parent_id);
  }

  public function getParentsByStudentId($student_id){
    $student = Student::find($student_id);
    
    return Parents::whereIn('id',[$student->father_parent_id, $student->mother_parent_id]);
  }

  public function getExistingParentByIdentity($ktp, $kk, $sexType){
    
    return Parents::where('sex_type_value', $sexType)
            ->where(function($query) use ($ktp, $kk){
              $query
              ->orWhere('ktp', $ktp)
              ->orWhere('nkk', $kk);
            });            
  }

  public function getExistingParentByKtp($ktp, $sexType){    
    return Parents::where('sex_type_value', $sexType)->where('ktp', $ktp);            
  }  

  public function getExistingParentByEmail($email, $sexType){    
    return Parents::where('sex_type_value', $sexType)->where('email', $email);            
  }

  public function getExistingParentByMobilePhone($mobilePhone, $sexType){    
    return Parents::where('sex_type_value', $sexType)->where('mobilePhone', $mobilePhone);            
  }

  public function getExistingParentByKk($kk, $sexType){    
    return Parents::where('sex_type_value', $sexType)->where('nkk', $kk);            
  }

  
  public function getParentsByFilters($filters)
  {
    return  
    Parents::with([
      'user',
      'sex_type:parameters.value,parameters.name',
      'parent_type:parameters.value,parameters.name',
      'wali_type:parameters.value,parameters.name'
      ])
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    })
    ->when(isset($filters['parent_id']), function ($query) use ($filters) {
      $student = Student::where('father_parent_id',$filters['parent_id'])  
      ->orWhere('mother_parent_id',$filters['parent_id'])->first();
      return $query->whereIn('id',[$student->father_parent_id, $student->mother_parent_id]);
    })
    ->when(isset($filters['student_id']), function ($query) use ($filters) {
      $student = Student::where('id',$filters['student_id'])->first();
      return $query->whereIn('id',[$student->father_parent_id, $student->mother_parent_id]);
    });
  }

  public function getParentOptions($filters){
    return Parents::select('id','name')
    ->when(isset($filters['name']), function ($query) use ($filters) {
      return $query->where('name','like','%'.$filters['name'].'%');
    });
  }

  
  
  public function insertParent($data){
    Parents::insert($data);
  }

  public function insertParentGetId($data){
    return Parents::insertGetId($data);
  }

  public function insertGetParent($data){
    return Parents::create($data);
  }

  public function updateParent($data,$id){
    Parents::where('id', $id)
            ->update($data);
  }
  
  public function deleteParents($ids){
    Parents::whereIn('id', $ids)
            ->delete();
  }
}
