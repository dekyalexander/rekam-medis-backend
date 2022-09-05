<?php

namespace App\Repositories;

use App\Models\VisusDiagnosis;
use Carbon\Carbon;

class DiagnosisEyesRepository{
  protected $diagnosiseyes;

  public function __construct(VisusDiagnosis $diagnosiseyes){
    $this->diagnosiseyes = $diagnosiseyes;
  }

  public function getDiagnosisEyesById($id,$selects=['*']){
    return VisusDiagnosis::select($selects)
    ->where('id','=',$id);
  }

  public function getDiagnosisEyeByCode($diagnosiskode,$diagnosisname){
    return VisusDiagnosis::
    where('diagnosis_kode','=',$diagnosiskode)
    ->where('diagnosis_name','=',$diagnosisname)
    ->count();
  } 

  public function getDiagnosisEyesOptions($filters){
    return VisusDiagnosis::select('id', 'diagnosis_kode','diagnosis_name','created_at')
    ->when(isset($filters['diagnosis_name']), function ($query) use ($filters) {
      return $query->where('diagnosis_name','like','%'.$filters['diagnosis_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }

  public function insert($data){
    VisusDiagnosis::insert($data);
  }

  public function updateDiagnosisEyes($data,$id){
    VisusDiagnosis::where('id', $id)
            ->update($data);
  }
  
  public function deleteDiagnosisEyes($ids){
    VisusDiagnosis::whereIn('id', $ids)
            ->delete();
  }

}
