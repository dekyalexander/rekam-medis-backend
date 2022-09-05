<?php

namespace App\Repositories;

use App\Models\EmployeeCurrentHealthHistory;
use App\Models\EmployeeCovid19VaccineHistory;
use App\Models\EmployeeHospitalizationHistory;
use App\Models\EmployeeFamilyHistoryOfIllness;
use App\Models\EmployeeHistoryOfComorbidities;
use App\Models\EmployeePastMedicalHistory;
use App\Models\EmployeeHRIS;
use App\Models\GeneralDiagnosis;
use Carbon\Carbon;

class EmployeeCurrentHealthHistoryRepository{
  protected $employeecurrenthealthhistory;

  public function __construct(EmployeeCurrentHealthHistory $employeecurrenthealthhistory){
    $this->employeecurrenthealthhistory = $employeecurrenthealthhistory;
  }

  public function getGeneralDiagnosisById($id,$selects=['*']){
    return GeneralDiagnosis::select($selects)
    ->where('id','=',$id);
  }

  public function getEmployeeCurrentHealthHistoryById($id,$selects=['*']){
    return EmployeeCurrentHealthHistory::select($selects)
    ->where('id','=',$id);
  }

  public function getFileOptions($filters, $id){
    return EmployeeCurrentHealthHistory::where('id', $id)
            ->get();
  }  

  public function getGeneralDiagnosisOptions($filters){
    return GeneralDiagnosis::select('id','diagnosis_name')
    ->when(isset($filters['diagnosis_name']), function ($query) use ($filters) {
      return $query->where('diagnosis_name','like','%'.$filters['diagnosis_name'].'%');
    })
    ->when(isset($filters['id']), function ($query) use ($filters) {
      return $query->where('id','=',$filters['id']);
    });
  }

  public function getEmployeeCurrentHealthHistoryOptions($filters){

    $employee = EmployeeHRIS::where('user_id', $filters['user_id'])->first();
 
    // if(!empty($filters['unit_id'])){
    //   $unit_id = $filters['unit_id'];
    // }else{
    //   $unit_id = '';
    // }

    if(!empty($filters['roles_id'])){
      $roles_id = $filters['roles_id'];
    }else{
      $roles_id = '';
    }


    //echo "tes".$unit_id;
    

    return EmployeeCurrentHealthHistory::select('id','name','nik','unit','blood_group','blood_group_rhesus','basic_immunization','history_of_drug_allergy','covid19_illness_history','covid19_sick_date','covid19_vaccine_history','covid19_vaccine_description','file','created_at')
    ->with(['employee'=>function($query){
      $query->select('id', 'name');
    }])
     ->with(['employeeunit'=>function($query){
      $query->select('id', 'name');
    }])
    ->with(['employeecovid19vaccinehistory'=>function($query){
      $query->select('id',
      'vaccine_to',
        'vaccine_date',
        'employee_health_id');
    }])
     ->with(['employeehistoryofcomorbidities'=>function($query){
      $query->select('id',
      'history_of_comorbidities',
        'employee_health_id');
    }])
    ->with(['employeefamilyhistoryofillness'=>function($query){
      $query->select('id',
      'family_history_of_illness',
        'employee_health_id');
    }])
    ->with(['employeepastmedicalhistory'=>function($query){
      $query->select('id',
      'past_medical_history',
        'employee_health_id');
    }])
    ->with(['employeehospitalizationhistory'=>function($query){
      $query->select('id',
      'hospital_name',
        'date_treated',
        'diagnosis',
        'other_diagnosis',
        'employee_health_id');
    }])
   

    ->when($roles_id=='21', function ($query) use ($roles_id) {
      return $query;
    })
    ->when($roles_id!='21', function ($query) use ($employee) {
      return $query->where('nik','=', $employee->nik);
    })
    
     ->when(isset($filters['unit']), function ($query) use ($filters) {
              return $query->Where('unit', $filters['unit']);
            })
    // ->when(isset($filters['name']), function ($query) use ($filters) {
    //   return $query->where('name','like','%'.$filters['name'].'%');
    // })
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    });
  }

  public function insert($data_current_health_history){
   $db =  EmployeeCurrentHealthHistory::create($data_current_health_history);
   return $db->id;

  }

  public function insert2($data_covid19_vaccine_history){
    EmployeeCovid19VaccineHistory::insert($data_covid19_vaccine_history);
  }

  public function insert3($data_hospitalization_history){
    EmployeeHospitalizationHistory::insert($data_hospitalization_history);
  }

  public function insert4($data_history_of_comorbidities){
    EmployeeHistoryOfComorbidities::insert($data_history_of_comorbidities);
  }

  public function insert5($data_past_medical_history){
    EmployeePastMedicalHistory::insert($data_past_medical_history);
  }

  public function insert6($data_family_history_of_illness){
    EmployeeFamilyHistoryOfIllness::insert($data_family_history_of_illness);
  }


  public function updateData($data_to_service, $id_vaccine)
  {

    return  EmployeeCovid19VaccineHistory::where('id', $id_vaccine)
            ->update($data_to_service);
                  
      
  }

   public function updateData2($data_to_service, $id_hospital)
  {

    return  EmployeeHospitalizationHistory::where('id', $id_hospital)
            ->update($data_to_service);
                  
      
  }

  public function updateData3($data_to_service, $id_comorbidities)
  {

    return  EmployeeHistoryOfComorbidities::where('id', $id_comorbidities)
            ->update($data_to_service);
                  
      
  }

  public function updateData4($data_to_service, $id_past)
  {

    return  EmployeePastMedicalHistory::where('id', $id_past)
            ->update($data_to_service);
                  
      
  }

  public function updateData5($data_to_service, $id_family)
  {

    return  EmployeeFamilyHistoryOfIllness::where('id', $id_family)
            ->update($data_to_service);
                  
      
  }


  public function updateData6($data, $id)
  {

    EmployeeCurrentHealthHistory::where('id', $id)
            ->update($data);
                  
      
  }

  public function insertUpdate1($data_to_service){
    EmployeeCovid19VaccineHistory::insert($data_to_service);
  }

  public function insertUpdate2($data_to_service){
    EmployeeHospitalizationHistory::insert($data_to_service);
  }

  public function insertUpdate3($data_to_service){
    EmployeeHistoryOfComorbidities::insert($data_to_service);
  }

  public function insertUpdate4($data_to_service){
    EmployeePastMedicalHistory::insert($data_to_service);
  }

  public function insertUpdate5($data_to_service){
    EmployeeFamilyHistoryOfIllness::insert($data_to_service);
  }

  public function deleteEmployeeCurrentHealthHistory($ids){
    EmployeeCurrentHealthHistory::whereIn('id', $ids)
            ->delete();
  }

}
