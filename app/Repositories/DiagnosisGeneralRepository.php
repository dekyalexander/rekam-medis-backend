<?php

namespace App\Repositories;

use App\Models\GeneralDiagnosis;
use Carbon\Carbon;

class DiagnosisGeneralRepository{
  protected $diagnosisgeneral;

  public function __construct(GeneralDiagnosis $diagnosisgeneral){
    $this->diagnosisgeneral = $diagnosisgeneral;
  }

  public function getDiagnosisGeneralById($id,$selects=['*']){
    return GeneralDiagnosis::select($selects)
    ->where('id','=',$id);
  }

  public function getDiagnosisGeneralByCode($diagnosiskode,$diagnosisname){
    return GeneralDiagnosis::
    where('diagnosis_kode','=',$diagnosiskode)
    ->where('diagnosis_name','=',$diagnosisname)
    ->count();
  } 

  public function getDiagnosisGeneralOptions($filters){
    return GeneralDiagnosis::select('id','diagnosis_kode','diagnosis_name','created_at')
    ->when(isset($filters['diagnosis_name']), function ($query) use ($filters) {
      return $query->where('diagnosis_name','like','%'.$filters['diagnosis_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }

  public function insert($data){
    GeneralDiagnosis::insert($data);
  }

  public function updateDiagnosisGeneral($data,$id){
    GeneralDiagnosis::where('id', $id)
            ->update($data);
  }
  
  public function deleteDiagnosisGeneral($ids){
    GeneralDiagnosis::whereIn('id', $ids)
            ->delete();
  }

}
