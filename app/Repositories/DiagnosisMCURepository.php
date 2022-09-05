<?php

namespace App\Repositories;

use App\Models\MCUDiagnosis;
use Carbon\Carbon;

class DiagnosisMCURepository{
  protected $diagnosismcu;

  public function __construct(MCUDiagnosis $diagnosismcu){
    $this->diagnosismcu = $diagnosismcu;
  }

  public function getDiagnosisMCUById($id,$selects=['*']){
    return MCUDiagnosis::select($selects)
    ->where('id','=',$id);
  }

  public function getDiagnosisMCUByCode($diagnosiskode,$diagnosisname){
    return MCUDiagnosis::
    where('diagnosis_kode','=',$diagnosiskode)
    ->where('diagnosis_name','=',$diagnosisname)
    ->count();
  } 

  public function getDiagnosisMCUOptions($filters){
    return MCUDiagnosis::select('id','diagnosis_kode','diagnosis_name','created_at')
    ->when(isset($filters['diagnosis_name']), function ($query) use ($filters) {
      return $query->where('diagnosis_name','like','%'.$filters['diagnosis_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }

  public function insert($data){
    MCUDiagnosis::insert($data);
  }

  public function updateDiagnosisMCU($data,$id){
    MCUDiagnosis::where('id', $id)
            ->update($data);
  }
  
  public function deleteDiagnosisMCU($ids){
    MCUDiagnosis::whereIn('id', $ids)
            ->delete();
  }


}
