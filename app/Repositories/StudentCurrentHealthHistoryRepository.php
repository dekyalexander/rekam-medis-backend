<?php

namespace App\Repositories;

use App\Models\StudentCurrentHealthHistory;
use App\Models\StudentBirthTimeData;
use App\Models\BasicImmunizationHistory;
use App\Models\StudentCovid19VaccineHistory;
use App\Models\StudentHospitalizationHistory;
use App\Models\StudentFamilyHistoryOfIllness;
use App\Models\StudentHistoryOfComorbidities;
use App\Models\StudentPastMedicalHistory;
use App\Models\GeneralDiagnosis;
use App\Models\Student;
use Carbon\Carbon;

class StudentCurrentHealthHistoryRepository{
  protected $studentcurrenthealthhistory;

  public function __construct(StudentCurrentHealthHistory $studentcurrenthealthhistory){
    $this->studentcurrenthealthhistory = $studentcurrenthealthhistory;
  }

  public function getGeneralDiagnosisById($id,$selects=['*']){
    return GeneralDiagnosis::select($selects)
    ->where('id','=',$id);
  }

  public function getStudentCurrentHealthHistoryById($id,$selects=['*']){
    return StudentCurrentHealthHistory::select($selects)
    ->where('id','=',$id);
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

  public function getStudentCurrentHealthHistoryOptions($filters){
    $student = Student::where('user_id', $filters['user_id'])->first();
    if(!empty($filters['roles_id'])){
      $roles_id = $filters['roles_id'];
    }else{
      $roles_id = '';
    }
    return StudentCurrentHealthHistory::select('id',
    'name',
    'niy',
    'level',
    'kelas',
    'blood_group',
    'blood_group_rhesus',
    'history_of_drug_allergy',
    'covid19_illness_history',
    'covid19_sick_date',
    'covid19_vaccine_history',
    'covid19_vaccine_description',
    'created_at')
    ->with(['student'=>function($query){
      $query->select('id', 'name','niy');
    }])
    ->with(['studentcovid19vaccinehistory'=>function($query){
      $query->select('id',"vaccine_to",
        'vaccine_date','student_health_id');
    }])
    ->with(['studentbirthtimedata'=>function($query){
      $query->select('id', 'weight',
        'height',
        'head_circumference',
        'month',
        'birth_condition',
        'indication','student_health_id');
    }])
    ->with(['basicimmunizationhistory'=>function($query){
      $query->select('id','type_of_immunization',
        'immunization_date',
        'value',
        'student_health_id');
    }])
     ->with(['studenthistoryofcomorbidities'=>function($query){
      $query->select('id',
      'history_of_comorbidities',
        'student_health_id');
    }])
    ->with(['studentfamilyhistoryofillness'=>function($query){
      $query->select('id',
      'family_history_of_illness',
        'student_health_id');
    }])
    ->with(['studentpastmedicalhistory'=>function($query){
      $query->select('id',
      'past_medical_history',
        'student_health_id');
    }])
    ->with(['studenthospitalizationhistory'=>function($query){
      $query->select('id','hospital_name',
        'date_treated',
        'diagnosis',
        'other_diagnosis',
        'student_health_id');
    }])

    ->when($roles_id=='21', function ($query) use ($roles_id) {
      return $query;
    })
    ->when($roles_id!='21', function ($query) use ($student) {
      return $query->where('niy','=', $student->niy);
    })
    
    ->when(isset($filters['level']), function ($query) use ($filters) {
        return $query->Where('level', $filters['level']);
      })
      ->when(isset($filters['kelas']), function ($query) use ($filters) {
        return $query->Where('kelas', $filters['kelas']);
      })
    // ->when(isset($filters['name']), function ($query) use ($filters) {
    //   return $query->where('name','like','%'.$filters['name'].'%');
    // })
    ->when(isset($filters['keyword']), function ($query) use ($filters) {
      return $query->orWhere('name','like','%'.$filters['keyword'].'%');
    });
  }

  public function insert($data_birth_time_data){
    StudentBirthTimeData::insert($data_birth_time_data);
  }

  public function insert2($data_current_health_history){
    $db = StudentCurrentHealthHistory::create($data_current_health_history);
    return $db->id;
  }

  public function insert3($data_hospitalization_history){
    StudentHospitalizationHistory::insert($data_hospitalization_history);
  }

  public function insert4($data_history_of_comorbidities){
    StudentHistoryOfComorbidities::insert($data_history_of_comorbidities);
  }

  public function insert5($data_past_medical_history){
    StudentPastMedicalHistory::insert($data_past_medical_history);
  }

  public function insert6($data_family_history_of_illness){
    StudentFamilyHistoryOfIllness::insert($data_family_history_of_illness);
  }

   public function insert7($data_basic_immunization_history){
    BasicImmunizationHistory::insert($data_basic_immunization_history);
  }

  public function insert8($data_covid19_vaccine_history){
    StudentCovid19VaccineHistory::insert($data_covid19_vaccine_history);
  }


   public function updateData($data_to_service, $id_vaccine)
  {

    return  StudentCovid19VaccineHistory::where('id', $id_vaccine)
            ->update($data_to_service);
                  
      
  }


  public function updateData2($data_to_service, $id_immunization)
  {

    return  BasicImmunizationHistory::where('id', $id_immunization)
            ->update($data_to_service);
                  
      
  }

   public function updateData3($data_to_service, $id_hospital)
  {

    return  StudentHospitalizationHistory::where('id', $id_hospital)
            ->update($data_to_service);
                  
      
  }

  public function updateData4($data_to_service, $id_comorbidities)
  {

    return  StudentHistoryOfComorbidities::where('id', $id_comorbidities)
            ->update($data_to_service);
                  
      
  }

  public function updateData5($data_to_service, $id_past)
  {

    return  StudentPastMedicalHistory::where('id', $id_past)
            ->update($data_to_service);
                  
      
  }

  public function updateData6($data_to_service, $id_family)
  {

    return  StudentFamilyHistoryOfIllness::where('id', $id_family)
            ->update($data_to_service);
                  
      
  }


  public function updateData7($data_current_health_history, $id)
  {

    StudentCurrentHealthHistory::where('id', $id)
            ->update($data_current_health_history);
                  
      
  }

  public function updateData8($data_birth_time_data, $id)
  {

    StudentBirthTimeData::where('id', $id)
            ->update($data_birth_time_data);
                  
      
  }

  public function insertUpdate1($data_to_service){
    StudentCovid19VaccineHistory::insert($data_to_service);
  }

  public function insertUpdate2($data_to_service){
    BasicImmunizationHistory::insert($data_to_service);
  }

  public function insertUpdate3($data_to_service){
    StudentHospitalizationHistory::insert($data_to_service);
  }

  public function insertUpdate4($data_to_service){
    StudentHistoryOfComorbidities::insert($data_to_service);
  }

  public function insertUpdate5($data_to_service){
    StudentPastMedicalHistory::insert($data_to_service);
  }

  public function insertUpdate6($data_to_service){
    StudentFamilyHistoryOfIllness::insert($data_to_service);
  }


  public function deleteStudentCurrentHealthHistory($ids){
    StudentCurrentHealthHistory::whereIn('id', $ids)
            ->delete();
  }


}
