<?php

namespace App\Repositories;

use App\Models\StudentMCU;
use App\Models\StudentTreatment;
use App\Models\Jenjang;
use App\Models\EyeVisus;
use App\Models\BMIDiagnosis;
use App\Models\MCUDiagnosis;
use App\Models\VisusDiagnosis;
use App\Models\GeneralDiagnosis;
use Carbon\Carbon;

class StudentRecapDiagnosisRepository{
  protected $studentMCURecapDiagnosis;
  protected $studentTreatmentRecapDiagnosis;

  public function __construct(StudentMCU $studentMCURecapDiagnosis, StudentTreatment $studentTreatmentRecapDiagnosis){
    $this->studentMCURecapDiagnosis = $studentMCURecapDiagnosis;
    $this->studentTreatmentRecapDiagnosis = $studentTreatmentRecapDiagnosis;
  }

  public function dataMCU($request)
  {

    $diagnosis_general_id = $request->diagnosis_general_id;

    $diagnosis_eye_id = $request->diagnosis_eye_id;

    $diagnosis_dental_id = $request->diagnosis_dental_id;

    $query =  $this->studentMCURecapDiagnosis::with(['studentmcugeneraldiagnosis.generaldiagnosis'])
              ->with(['studentmcueyediagnosis.visusdiagnosis'])
              ->with(['studentmcudentalandoraldiagnosis.mcudiagnosis'])
              ->with(['jenjang:id,name,code','kelas:id,name,code'])
              // ->with(['studentmcueyediagnosis'=>function($query){
              //   $query->select('id','student_mcu_id','diagnosis_name');
              // }])
              // ->with(['studentmcueyediagnosis'=>function($query){
              //       $query->select('id','student_mcu_id','diagnosis_name');
              //   }])
              // ->with(['studentmcudentalandoraldiagnosis'=>function($query){
              //     $query->select('id','student_mcu_id','diagnosis_name');
              //   }])
              ->when(isset($request['code']), function ($query) use ($request) {
                return $query->orWhere('code', $request['code']);
              })
              ->when(isset($request['level']), function ($query) use ($request) {
                return $query->Where('level', $request['level']);
              })
              ->when(isset($request['kelas']), function ($query) use ($request) {
                return $query->Where('kelas', $request['kelas']);
              })
              ->when(isset($request['kelas']), function ($query) use ($request) {
                return $query->Where('kelas', $request['kelas']);
              })
              ->when(isset($request['inspection_date']), function ($query) use ($request) {
                return $query->WhereDate('inspection_date','<=', $request['inspection_date']);
              })->orderBy('name', 'ASC');
              
              if($diagnosis_general_id){
                $query->WhereHas('studentmcugeneraldiagnosis', function ($q) use($diagnosis_general_id) {
                  return $q->where('diagnosis_general_id', $diagnosis_general_id);
                });
              }

              if($diagnosis_eye_id){
                $query->WhereHas('studentmcueyediagnosis', function ($q) use($diagnosis_eye_id) {
                  return $q->Where('diagnosis_eye_id', $diagnosis_eye_id);
                });
              }

              if($diagnosis_dental_id){
                $query->WhereHas('studentmcudentalandoraldiagnosis', function ($q) use($diagnosis_dental_id) {
                  return $q->Where('diagnosis_dental_id', $diagnosis_dental_id);
                });
              }

              return $query;

              // ->with(['jenjang:id,name,code','kelas:id,name,code','visusdiagnosis:id,diagnosis_kode,diagnosis_name','mcudiagnosis:id,diagnosis_kode,diagnosis_name','generaldiagnosis:id,diagnosis_name'])
              // ->with(['jenjang:id,name,code','kelas:id,name,code']);
              //->with(['studentmcugeneraldiagnosis.generaldiagnosis'])
              // ->with(['studentmcueyediagnosis'=>function($query){
              //   $query->select('id','student_mcu_id','diagnosis_name');
              // }])
              // ->with(['studentmcudentalandoraldiagnosis'=>function($query){
              //   $query->select('id','student_mcu_id','diagnosis_name');
              // }])
              // ->when(isset($request['diagnosis_name']), function ($query) use ($request) {
              //     return $query->orWhere('diagnosis_name', $request['diagnosis_name']);
              //   })
              //   ->when(isset($request['code']), function ($query) use ($request) {
              //     return $query->orWhere('code', $request['code']);
              //   })
              //   ->when(isset($request['level']), function ($query) use ($request) {
              //     return $query->Where('level', $request['level']);
              //   })
              //   ->when(isset($request['kelas']), function ($query) use ($request) {
              //     return $query->Where('kelas', $request['kelas']);
              //   })
              //   ->when(isset($request['kelas']), function ($query) use ($request) {
              //     return $query->Where('kelas', $request['kelas']);
              //   })
              //   ->when(isset($request['inspection_date']), function ($query) use ($request) {
              //     return $query->WhereDate('inspection_date','<=', $request['inspection_date']);
              //   })
              //   ->when(isset($request['general_diagnosis']), function ($query) use ($request) {
              //     return $query->Where('general_diagnosis', $request['general_diagnosis']);
              //   })
              //   ->when(isset($request['eye_diagnosis']), function ($query) use ($request) {
              //     return $query->Where('eye_diagnosis', $request['eye_diagnosis']);
              //   })
              //   ->when(isset($request['dental_diagnosis']), function ($query) use ($request) {
              //     return $query->Where('dental_diagnosis', $request['dental_diagnosis']);
              //   })
              //   ->when(isset($request['created_at']), function ($query) use ($request) {
              //     return $query->WhereDate('created_at','>=', $request['created_at']);
              //   })->orderBy('name', 'ASC');
  }

  public function dataTreatment($request)
  {
    $diagnosis_id = $request->diagnosis_id;

    $query = $this->studentTreatmentRecapDiagnosis->with(['jenjang:id,name,code','kelas:id,name,code','studenttreatmentgeneraldiagnosis.generaldiagnosis'])
            // ->when(isset($request['diagnosis_name']), function ($query) use ($request) {
            //   return $query->orWhere('diagnosis_name', $request['diagnosis_name']);
            // })
            ->when(isset($request['level']), function ($query) use ($request) {
              return $query->Where('level', $request['level']);
            })
            ->when(isset($request['kelas']), function ($query) use ($request) {
              return $query->Where('kelas', $request['kelas']);
            })
            ->when(isset($request['inspection_date']), function ($query) use ($request) {
              return $query->WhereDate('inspection_date','<=', $request['inspection_date']);
            })
            ->when(isset($request['created_at']), function ($query) use ($request) {
              return $query->WhereDate('created_at','>=', $request['created_at']);
            })->orderBy('name', 'ASC');

            if($diagnosis_id){
                $query->WhereHas('studenttreatmentgeneraldiagnosis', function ($q) use($diagnosis_id) {
                  return $q->where('diagnosis_id', $diagnosis_id);
                });
              }
            return $query;
  }
}
