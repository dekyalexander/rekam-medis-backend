<?php

namespace App\Repositories;

use App\Models\BMIDiagnosis;
use Carbon\Carbon;

class DiagnosisBMIRepository{
  protected $diagnosisbmi;

  public function __construct(BMIDiagnosis $diagnosisbmi){
    $this->diagnosisbmi = $diagnosisbmi;
  }

  public function getDiagnosisBMIById($id,$selects=['*']){
    return BMIDiagnosis::select($selects)
    ->where('id','=',$id);
  }

  public function getDiagnosisBMIByCode($diagnosiskode,$diagnosisname){
    return BMIDiagnosis::
    where('diagnosis_kode','=',$diagnosiskode)
    ->where('diagnosis_name','=',$diagnosisname)
    ->count();
  } 

  public function getDiagnosisBMIOptions($filters){
    return BMIDiagnosis::select('id', 'diagnosis_kode', 'diagnosis_name', 'created_at')
    ->when(isset($filters['diagnosis_name']), function ($query) use ($filters) {
      return $query->where('diagnosis_name','like','%'.$filters['diagnosis_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }

  public function insert($data){
    BMIDiagnosis::insert($data);
  }

  public function updateDiagnosisBMI($data,$id){
    BMIDiagnosis::where('id', $id)
            ->update($data);
  }
  
  public function deleteDiagnosisBMI($ids){
    BMIDiagnosis::whereIn('id', $ids)
            ->delete();
  }


}
