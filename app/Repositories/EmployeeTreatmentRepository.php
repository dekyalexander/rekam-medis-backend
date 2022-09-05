<?php

namespace App\Repositories;

use App\Models\EmployeeTreatment;
use App\Models\EmployeeTreatmentGeneralDiagnosis;
use App\Models\Anamnesis;
use App\Models\GeneralPhysicalExamination;
use App\Models\EmployeeVitalSigns;
use App\Models\EmployeeMedicalPrescription;
use App\Models\GeneralDiagnosis;
use App\Models\Transactions;
use App\Models\EmployeeHRIS;
use Carbon\Carbon;

class EmployeeTreatmentRepository{
  protected $employeetreatment;

  public function __construct(EmployeeTreatment $employeetreatment){
    $this->employeetreatment = $employeetreatment;
  }

  public function getEmployeeTreatmentOptions($filters){
    $employee = EmployeeHRIS::where('user_id', $filters['user_id'])->first();
    if(!empty($filters['roles_id'])){
      $roles_id = $filters['roles_id'];
    }else{
      $roles_id = '';
    }
    return EmployeeTreatment::select(
      'id',
      'name',
      'nik',
      'unit',
      'inspection_date',
      'anamnesa',
      'head',
      'neck',
      'eye',
      'nose',
      'tongue',
      'tooth',
      'gum',
      'throat',
      'tonsils',
      'ear',
      'lymph_nodes_and_neck',
      'heart',
      'lungs',
      'epigastrium',
      'hearts',
      'spleen',
      'intestines',
      'hand',
      'foot',
      'skin',
      'description',
      'file',
      'created_at')
    ->with(['employee'=>function($query){
      $query->select('id', 'name');
    }])
     ->with(['employeeunit'=>function($query){
      $query->select('id', 'name');
    }])
    ->with(['generalphysicalexamination'=>function($query){
      $query->select('awareness',
        'distress_sign',
        'anxiety_sign',
        'sign_of_pain',
        'voice',
        'employee_treat_id');
    }])
    // ->with(['generaldiagnosis'=>function($query){
    //   $query->select('id',
    //     'diagnosis_name');
    // }])
    ->with(['employeevitalsigns'=>function($query){
      $query->select(
        'blood_pressure',
        'heart_rate',
        'breathing_ratio',
        'body_temperature',
        'sp02',
        'employee_treat_id');
    }])
    ->with(['employeetreatmentgeneraldiagnosis.generaldiagnosis'])
    ->with('employeemedicalprescription.drugname')
    ->with('employeemedicalprescription.listofukslocations')
   

    ->when($roles_id=='21', function ($query) use ($roles_id) {
      return $query;
    })
    ->when($roles_id!='21', function ($query) use ($employee) {
      return $query->where('nik','=', $employee->nik);
    })

     ->when(isset($filters['unit']), function ($query) use ($filters) {
              return $query->Where('unit', $filters['unit']);
            })
       ->when(isset($filters['inspection_date']), function ($query) use ($filters) {
        return $query->WhereDate('inspection_date','<=',$filters['inspection_date']);
      })
      ->when(isset($filters['created_at']), function ($query) use ($filters) {
        return $query->WhereDate('created_at','>=',$filters['created_at']);
      })
    // ->when(isset($filters['name']), function ($query) use ($filters) {
    //   return $query->where('name','like','%'.$filters['name'].'%');
    // })
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    });
  }


  //public function getEmployeeTreatmentOptions($filters){
    //return EmployeeTreatment::select('id','name','inspection_date','head','neck','eye','nose','tongue','tooth','gum','throat','tonsils','ear','lymph_nodes_and_neck','heart','lungs','epigastrium','hearts','spleen','intestines','hand','foot','skin','diagnosis','suggestion','description','created_at')
    //->when(isset($filters['name']), function ($query) use ($filters) {
      //return $query->where('name','like','%'.$filters['name'].'%');
    //})
    //->when(isset($filters['id']), function ($query) use ($filters) {
      //return $query->where('id','=',$filters['id']);
    //});
  //}


  public function insert($data_employee_treatment){
    $db = EmployeeTreatment::create($data_employee_treatment);
    return $db->id;
  }

  public function insert2($data_general_physical_examination){
    GeneralPhysicalExamination::insert($data_general_physical_examination);
  }

  public function insert3($data_vital_signs){
    EmployeeVitalSigns::insert($data_vital_signs);
  }

  public function insert4($data_medical_prescription){
    EmployeeMedicalPrescription::insert($data_medical_prescription);
  }

   public function insert5($transactions){
    Transactions::insert($transactions);
  }

  public function insert6($data_general_diagnosis){
     EmployeeTreatmentGeneralDiagnosis::insert($data_general_diagnosis);
  }

  public function update($data_to_service, $id_medical){
    EmployeeMedicalPrescription::where('id', $id_medical)
            ->update($data_to_service);
  }

  public function update2($data_employee_treatment, $id){
    EmployeeTreatment::where('id', $id)
            ->update($data_employee_treatment);
  }

  public function update3($data_general_physical_examination, $id){
    GeneralPhysicalExamination::where('id', $id)
            ->update($data_general_physical_examination);
  }

  public function update4($data_vital_signs, $id){
    EmployeeVitalSigns::where('id', $id)
            ->update($data_vital_signs);
  }

  public function update5($data_to_service, $id_general_diagnosis){
    EmployeeTreatmentGeneralDiagnosis::where('id', $id_general_diagnosis)
            ->update($data_to_service);
  }

  public function insertUpdate($data_to_service){
    EmployeeMedicalPrescription::insert($data_to_service);
  }

  public function insertUpdate1($data_to_service){
    EmployeeTreatmentGeneralDiagnosis::insert($data_to_service);
  }

  public function deleteEmployeeTreatment($ids){
    EmployeeTreatment::whereIn('id', $ids)
            ->delete();
  }

}
