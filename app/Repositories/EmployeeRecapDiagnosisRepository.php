<?php

namespace App\Repositories;

use App\Models\EmployeeTreatment;
use App\Models\EmployeeMCU;
use App\Models\GeneralDiagnosis;
use Carbon\Carbon;

class EmployeeRecapDiagnosisRepository{
  protected $employeeTreatmentRecapDiagnosis;
  protected $employeeMCURecapDiagnosis;

  public function __construct(EmployeeTreatment $employeeTreatmentRecapDiagnosis, EmployeeMCU $employeeMCURecapDiagnosis){
    $this->employeeTreatmentRecapDiagnosis = $employeeTreatmentRecapDiagnosis;
    $this->employeeMCURecapDiagnosis = $employeeMCURecapDiagnosis;
  }

  public function dataTreatment($request)
  {
    $diagnosis_id = $request->diagnosis_id;

    $query = $this->employeeTreatmentRecapDiagnosis->with(['employeetreatmentgeneraldiagnosis.generaldiagnosis','employeeunit:id,name'])
            //  ->when(isset($request['diagnosis_name']), function ($query) use ($request) {
            //   return $query->orWhere('diagnosis_name', $request['diagnosis_name']);
            // })
            ->when(isset($request['name']), function ($query) use ($request) {
              return $query->orWhere('name', $request['name']);
            })
            // ->when(isset($request['diagnosis']), function ($query) use ($request) {
            //   return $query->Where('diagnosis', $request['diagnosis']);
            // })
             ->when(isset($request['unit']), function ($query) use ($request) {
              return $query->Where('unit', $request['unit']);
            })
            ->when(isset($request['inspection_date']), function ($query) use ($request) {
              return $query->WhereDate('inspection_date','<=', $request['inspection_date']);
            })
            ->when(isset($request['created_at']), function ($query) use ($request) {
              return $query->WhereDate('created_at','>=', $request['created_at']);
            })
            ->orderBy('name', 'ASC');

            if($diagnosis_id){
                $query->WhereHas('employeetreatmentgeneraldiagnosis', function ($q) use($diagnosis_id) {
                  return $q->where('diagnosis_id', $diagnosis_id);
                });
              }
            return $query;
  }
  public function dataMCU($request)
  {
    $diagnosis_id = $request->diagnosis_id;

    $query = $this->employeeMCURecapDiagnosis->with(['employeemcugeneraldiagnosis.generaldiagnosis','employeeunit:id,name'])
            //  ->when(isset($request['diagnosis_name']), function ($query) use ($request) {
            //   return $query->orWhere('diagnosis_name', $request['diagnosis_name']);
            // })
            ->when(isset($request['name']), function ($query) use ($request) {
              return $query->orWhere('name', $request['name']);
            })
            // ->when(isset($request['diagnosis']), function ($query) use ($request) {
            //   return $query->Where('diagnosis', $request['diagnosis']);
            // })
             ->when(isset($request['unit']), function ($query) use ($request) {
              return $query->Where('unit', $request['unit']);
            })
            ->when(isset($request['inspection_date']), function ($query) use ($request) {
              return $query->WhereDate('inspection_date','<=', $request['inspection_date']);
            })
            ->when(isset($request['created_at']), function ($query) use ($request) {
              return $query->WhereDate('created_at','>=', $request['created_at']);
            })
            ->orderBy('name', 'ASC');

            if($diagnosis_id){
                $query->WhereHas('employeemcugeneraldiagnosis', function ($q) use($diagnosis_id) {
                  return $q->where('diagnosis_id', $diagnosis_id);
                });
              }
            return $query;
  }
}
